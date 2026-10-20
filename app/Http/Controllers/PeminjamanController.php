<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $peminjaman = Peminjaman::with(['peminjam', 'petugas', 'alat.kategori'])->when($user->role === 'peminjam', function ($query) use ($user) {
            $query->where('id_user', $user->id);
        })->latest()->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('peminjaman.create', compact('alat', 'peminjam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
 
        $data = $request->validate([
            'id_alat'         => ['required', 'exists:alat,id'],
            'jumlah'          => ['required', 'integer', 'min:1'],
            'tanggal_kembali' => ['required', 'date', 'after_or_equal:today'],
            'keperluan'       => ['nullable', 'string', 'max:500'],
        ]);

        $alat = Alat::findOrFail($data['id_alat']);
        if ($data['jumlah'] > $alat->stok) {
            throw ValidationException::withMessages([
                'jumlah' => "Stok {$alat->nama_alat} hanya tersisa {$alat->stok}.",
            ]);
        }

        $data['id_user']           = Auth::id();
        $data['tanggal_pengajuan'] = now()->toDateString();
        $data['status']            = Peminjaman::STATUS_MENUNGGU;

        Peminjaman::create($data);
 
        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
 
    public function show(Peminjaman $peminjaman)
    {
        $this->authorizeAkses($peminjaman);
        $peminjaman->load(['peminjam', 'petugas', 'alat.kategori']);
 
        return view('peminjaman.show', compact('peminjaman'));
    }
 
    /** Admin */
    public function edit(Peminjaman $peminjaman)
    {
        $alat      = Alat::orderBy('nama_alat')->get();
        $peminjams = User::where('role', 'peminjam')->orderBy('name')->get();
 
        return view('peminjaman.edit', compact('peminjaman', 'alat', 'peminjams'));
    }
 
    /** Admin */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $data = $request->validate([
            'user_id'           => ['required', 'exists:users,id'],
            'alat_id'           => ['required', 'exists:alat,id'],
            'jumlah'            => ['required', 'integer', 'min:1'],
            'tanggal_pengajuan' => ['required', 'date'],
            'tanggal_kembali'   => ['required', 'date', 'after_or_equal:tanggal_pengajuan'],
            'keperluan'         => ['nullable', 'string', 'max:500'],
            'status'            => ['required', 'in:menunggu,disetujui,ditolak'],
            'catatan'           => ['nullable', 'string', 'max:500'],
        ]);
 
        $peminjaman->update($data);
 
        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }
 
    /** Admin. Stok dikembalikan bila pengajuan sudah disetujui. */
    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->status === Peminjaman::STATUS_DISETUJUI) {
                $peminjaman->alat()->increment('stok', $peminjaman->jumlah);
            }
            $peminjaman->delete();
        });
 
        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
 
    /* ------------------------------------------------------------------
     |  Petugas (route: peminjaman.setujui & peminjaman.tolak)
     * ----------------------------------------------------------------- */
 
    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }
 
        try {
            DB::transaction(function () use ($peminjaman) {
                $alat = Alat::lockForUpdate()->findOrFail($peminjaman->alat_id);
 
                if ($peminjaman->jumlah > $alat->stok) {
                    throw new \RuntimeException(
                        "Stok {$alat->nama_alat} tidak mencukupi (tersisa {$alat->stok})."
                    );
                }
 
                $alat->decrement('stok', $peminjaman->jumlah);
 
                $peminjaman->update([
                    'status'     => Peminjaman::STATUS_DISETUJUI,
                    'petugas_id' => Auth::id(),
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
 
        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }
 
    public function tolak(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }
 
        $request->validate(['catatan' => ['nullable', 'string', 'max:500']]);
 
        $peminjaman->update([
            'status'     => Peminjaman::STATUS_DITOLAK,
            'petugas_id' => Auth::id(),
            'catatan'    => $request->input('catatan'),
        ]);
 
        return back()->with('success', 'Peminjaman telah ditolak.');
    }
 
    /** Petugas: mencetak laporan. */
    public function laporan(Request $request)
    {
        $request->validate([
            'dari'   => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);
 
        $peminjaman = Peminjaman::with(['peminjam', 'petugas', 'alat.kategori'])
            ->when($request->dari, fn ($q, $v) => $q->whereDate('tanggal_pengajuan', '>=', $v))
            ->when($request->sampai, fn ($q, $v) => $q->whereDate('tanggal_pengajuan', '<=', $v))
            ->status($request->status)
            ->orderBy('tanggal_pengajuan')
            ->get();
 
        return view('peminjaman.laporan', compact('peminjaman'));
    }
 
    private function authorizeAkses(Peminjaman $peminjaman): void
    {
        $user = Auth::user();
 
        abort_if(
            $user->role === 'peminjam' && $peminjaman->user_id !== $user->id,
            403,
            'Anda tidak berhak mengakses data ini.'
        );
    }
}
