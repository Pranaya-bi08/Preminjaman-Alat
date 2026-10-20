<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class PeminjamController extends Controller
{
    /**
     * 1. Dashboard Peminjam (Ringkasan & Shortcut Menu)
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Data pengajuan & pinjaman peminjam
        $pengajuanList = Peminjaman::where('id_user', $user->id)
            ->with(['alat.kategori', 'petugas'])
            ->latest()
            ->get();

        $pinjamanAktif = $pengajuanList->filter(function ($item) {
            return $item->status === Peminjaman::STATUS_DISETUJUI && !$item->isSudahDikembalikan();
        });

        $riwayatPengembalian = $pengajuanList->filter(function ($item) {
            return $item->isSudahDikembalikan();
        });

        // Kategori & Alat ringkas
        $kategoris = Kategori::withCount('alat')->orderBy('nama_kategori')->get();
        $alatTersediaPreview = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->take(5)->get();
        $semuaAlatTersedia = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();

        // Statistik
        $stats = [
            'total_alat_tersedia' => Alat::where('stok', '>', 0)->count(),
            'total_pengajuan'     => $pengajuanList->count(),
            'menunggu'            => $pengajuanList->where('status', Peminjaman::STATUS_MENUNGGU)->count(),
            'dipinjam_aktif'      => $pinjamanAktif->count(),
            'sudah_kembali'       => $riwayatPengembalian->count(),
            'total_kategori'      => $kategoris->count(),
        ];

        // Pengajuan terbaru (max 5 data untuk preview dashboard)
        $pengajuanTerbaru = $pengajuanList->take(5);

        return view('peminjam.dashboard', compact(
            'stats',
            'kategoris',
            'alatTersediaPreview',
            'semuaAlatTersedia',
            'pinjamanAktif',
            'pengajuanTerbaru'
        ));
    }

    /**
     * 2. Halaman Khusus: Daftar & Kategori Alat
     */
    public function alat(Request $request)
    {
        $kategoris = Kategori::withCount('alat')->orderBy('nama_kategori')->get();

        $query = Alat::with('kategori');

        $selectedKategori = null;
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
            $selectedKategori = Kategori::find($request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        $alatList = $query->orderBy('nama_alat')->get();
        $semuaAlatTersedia = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('peminjam.alat.index', compact('kategoris', 'alatList', 'semuaAlatTersedia', 'selectedKategori'));
    }

    /**
     * 3. Halaman Khusus: Pengajuan Peminjaman Alat
     */
    public function pengajuan(Request $request)
    {
        $user = Auth::user();

        $query = Peminjaman::where('id_user', $user->id)
            ->with(['alat.kategori', 'petugas']);

        if ($request->filled('status')) {
            if ($request->status === 'dikembalikan') {
                $query->where('catatan', 'like', '%[DIKEMBALIKAN%');
            } else {
                $query->where('status', $request->status)
                      ->where(function($q) {
                          $q->whereNull('catatan')->orWhere('catatan', 'not like', '%[DIKEMBALIKAN%');
                      });
            }
        }

        $pengajuanList = $query->latest()->get();

        // Hitungan per status
        $allPengajuan = Peminjaman::where('id_user', $user->id)->get();
        $counts = [
            'semua'        => $allPengajuan->count(),
            'menunggu'     => $allPengajuan->where('status', Peminjaman::STATUS_MENUNGGU)->count(),
            'disetujui'    => $allPengajuan->filter(fn($p) => $p->status === Peminjaman::STATUS_DISETUJUI && !$p->isSudahDikembalikan())->count(),
            'ditolak'      => $allPengajuan->where('status', Peminjaman::STATUS_DITOLAK)->count(),
            'dikembalikan' => $allPengajuan->filter(fn($p) => $p->isSudahDikembalikan())->count(),
        ];

        $semuaAlatTersedia = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('peminjam.pengajuan.index', compact('pengajuanList', 'counts', 'semuaAlatTersedia'));
    }

    /**
     * 4. Halaman Khusus: Pengembalian Alat
     */
    public function pengembalian()
    {
        $user = Auth::user();

        $allUserLoans = Peminjaman::where('id_user', $user->id)
            ->with(['alat.kategori', 'petugas'])
            ->latest()
            ->get();

        // Pinjaman aktif yang harus dikembalikan
        $pinjamanAktif = $allUserLoans->filter(function ($item) {
            return $item->status === Peminjaman::STATUS_DISETUJUI && !$item->isSudahDikembalikan();
        });

        // Riwayat pengembalian yang sudah selesai
        $riwayatPengembalian = $allUserLoans->filter(function ($item) {
            return $item->isSudahDikembalikan();
        });

        return view('peminjam.pengembalian.index', compact('pinjamanAktif', 'riwayatPengembalian'));
    }

    /**
     * Simpan Pengajuan Peminjaman Alat
     */
    public function storePengajuan(Request $request)
    {
        $data = $request->validate([
            'id_alat'         => ['required', 'exists:alats,id'],
            'jumlah'          => ['required', 'integer', 'min:1'],
            'tanggal_kembali' => ['required', 'date', 'after_or_equal:today'],
            'keperluan'       => ['nullable', 'string', 'max:500'],
        ], [
            'id_alat.required'         => 'Silakan pilih alat yang ingin dipinjam.',
            'id_alat.exists'           => 'Alat yang dipilih tidak valid.',
            'jumlah.required'          => 'Jumlah unit alat wajib diisi.',
            'jumlah.min'               => 'Jumlah unit minimal 1.',
            'tanggal_kembali.required' => 'Tanggal rencana pengembalian wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali minimal hari ini atau setelahnya.',
        ]);

        $alat = Alat::findOrFail($data['id_alat']);

        if ($alat->stok < $data['jumlah']) {
            return back()->withInput()->with('error', "Stok {$alat->nama_alat} tidak mencukupi (tersisa {$alat->stok} unit).");
        }

        Peminjaman::create([
            'id_user'           => Auth::id(),
            'id_alat'           => $data['id_alat'],
            'jumlah'            => $data['jumlah'],
            'tanggal_pengajuan' => now()->toDateString(),
            'tanggal_kembali'   => $data['tanggal_kembali'],
            'keperluan'         => $data['keperluan'] ?? null,
            'status'            => Peminjaman::STATUS_MENUNGGU,
        ]);

        return redirect()->route('peminjam.pengajuan.index')
            ->with('success', "Pengajuan peminjaman untuk '{$alat->nama_alat}' berhasil dikirim! Menunggu persetujuan petugas.");
    }

    /**
     * Proses Pengembalian Alat
     */
    public function kembalikan(Request $request, $id)
    {
        $user = Auth::user();
        $peminjaman = Peminjaman::where('id', $id)
            ->where('id_user', $user->id)
            ->with('alat')
            ->firstOrFail();

        if ($peminjaman->status !== Peminjaman::STATUS_DISETUJUI) {
            return back()->with('error', 'Peminjaman ini belum disetujui atau sudah selesai.');
        }

        if ($peminjaman->isSudahDikembalikan()) {
            return back()->with('info', 'Alat ini sudah dikembalikan sebelumnya.');
        }

        $isOverdue = Carbon::parse($peminjaman->tanggal_kembali)->isPast() && !Carbon::parse($peminjaman->tanggal_kembali)->isToday();
        $statusReturn = $isOverdue ? 'terlambat' : 'sudah_dikembalikan';

        DB::transaction(function () use ($peminjaman, $statusReturn, $isOverdue) {
            // 1. Pulihkan stok alat
            if ($peminjaman->alat) {
                $peminjaman->alat()->increment('stok', $peminjaman->jumlah);
            }

            // 2. Catat riwayat di tabel pengembalians
            Pengembalian::create([
                'id_alat'     => $peminjaman->id_alat,
                'id_kategori' => $peminjaman->alat->id_kategori ?? 1,
                'status'      => $statusReturn,
            ]);

            // 3. Update catatan peminjaman
            $note = "[DIKEMBALIKAN: " . now()->format('d/m/Y H:i') . ($isOverdue ? " - Terlambat" : " - Tepat Waktu") . "]";
            $peminjaman->catatan = trim(($peminjaman->catatan ? $peminjaman->catatan . "\n" : "") . $note);
            $peminjaman->save();
        });

        $pesan = "Alat '{$peminjaman->alat?->nama_alat}' berhasil dikembalikan! Stok telah dipulihkan.";
        if ($isOverdue) {
            $pesan .= " (Status: Terlambat dari batas pengembalian {$peminjaman->tanggal_kembali})";
        }

        return redirect()->route('peminjam.pengembalian.index')
            ->with('success', $pesan);
    }
}
