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

class PetugasController extends Controller
{
    /**
     * 1. Dashboard Petugas
     */
    public function dashboard()
    {
        $allPeminjaman = Peminjaman::with(['peminjam', 'alat.kategori'])->latest()->get();

        $pinjamanAktif = $allPeminjaman->filter(function ($item) {
            return $item->status === Peminjaman::STATUS_DISETUJUI && !$item->isSudahDikembalikan();
        });

        $riwayatPengembalian = $allPeminjaman->filter(function ($item) {
            return $item->isSudahDikembalikan();
        });

        $pengajuanMenunggu = $allPeminjaman->where('status', Peminjaman::STATUS_MENUNGGU);

        $stats = [
            'menunggu'       => $pengajuanMenunggu->count(),
            'dipinjam_aktif' => $pinjamanAktif->count(),
            'sudah_kembali'  => $riwayatPengembalian->count(),
            'total_alat'     => Alat::count(),
            'stok_tersedia'  => Alat::sum('stok'),
            'total_transaksi'=> $allPeminjaman->count(),
        ];

        // Daftar pengajuan menunggu verifikasi (butuh tindakan segera)
        $antreanMenunggu = $pengajuanMenunggu->take(5);

        // Daftar peminjaman aktif yang mendekati / lewat batas waktu
        $perluDipantau = $pinjamanAktif->take(5);

        return view('petugas.dashboard', compact(
            'stats',
            'antreanMenunggu',
            'perluDipantau'
        ));
    }

    /**
     * 2. Halaman Menyetujui / Menolak Peminjaman
     */
    public function persetujuan(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'alat.kategori', 'petugas']);

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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('peminjam', function($userQ) use ($search) {
                    $userQ->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('alat', function($alatQ) use ($search) {
                    $alatQ->where('nama_alat', 'like', "%{$search}%");
                });
            });
        }

        $peminjamanList = $query->latest()->get();

        // Counter untuk filter tab
        $all = Peminjaman::all();
        $counts = [
            'semua'        => $all->count(),
            'menunggu'     => $all->where('status', Peminjaman::STATUS_MENUNGGU)->count(),
            'disetujui'    => $all->filter(fn($p) => $p->status === Peminjaman::STATUS_DISETUJUI && !$p->isSudahDikembalikan())->count(),
            'ditolak'      => $all->where('status', Peminjaman::STATUS_DITOLAK)->count(),
            'dikembalikan' => $all->filter(fn($p) => $p->isSudahDikembalikan())->count(),
        ];

        return view('petugas.penyetujuan.index', compact('peminjamanList', 'counts'));
    }

    /**
     * Proses Setujui Peminjaman
     */
    public function setujui($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
            return back()->with('error', 'Pengajuan ini sudah pernah diproses sebelumnya.');
        }

        try {
            DB::transaction(function () use ($peminjaman) {
                $alat = Alat::lockForUpdate()->findOrFail($peminjaman->id_alat);

                if ($peminjaman->jumlah > $alat->stok) {
                    throw new \RuntimeException(
                        "Stok {$alat->nama_alat} tidak mencukupi (tersisa {$alat->stok} unit, pengajuan butuh {$peminjaman->jumlah} unit)."
                    );
                }

                // Kurangi stok alat
                $alat->decrement('stok', $peminjaman->jumlah);

                // Update status peminjaman
                $peminjaman->update([
                    'status'     => Peminjaman::STATUS_DISETUJUI,
                    'id_petugas' => Auth::id(),
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Peminjaman '{$peminjaman->alat?->nama_alat}' oleh {$peminjaman->peminjam?->name} berhasil disetujui. Stok alat telah dikurangi.");
    }

    /**
     * Proses Tolak Peminjaman
     */
    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== Peminjaman::STATUS_MENUNGGU) {
            return back()->with('error', 'Pengajuan ini sudah pernah diproses sebelumnya.');
        }

        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500']
        ]);

        $alasan = $request->input('catatan') ?: 'Ditolak oleh petugas (alasan tidak dicantumkan).';

        $peminjaman->update([
            'status'     => Peminjaman::STATUS_DITOLAK,
            'id_petugas' => Auth::id(),
            'catatan'    => $alasan,
        ]);

        return back()->with('success', "Pengajuan peminjaman oleh {$peminjaman->peminjam?->name} telah ditolak.");
    }

    /**
     * 3. Halaman Memantau Pengembalian Alat
     */
    public function pengembalian(Request $request)
    {
        $query = Peminjaman::where('status', Peminjaman::STATUS_DISETUJUI)
            ->with(['peminjam', 'alat.kategori', 'petugas']);

        if ($request->filter === 'terlambat') {
            $query->whereDate('tanggal_kembali', '<', now()->toDateString())
                  ->where(function($q) {
                      $q->whereNull('catatan')->orWhere('catatan', 'not like', '%[DIKEMBALIKAN%');
                  });
        } elseif ($request->filter === 'selesai') {
            $query->where('catatan', 'like', '%[DIKEMBALIKAN%');
        } elseif ($request->filter === 'aktif') {
            $query->where(function($q) {
                $q->whereNull('catatan')->orWhere('catatan', 'not like', '%[DIKEMBALIKAN%');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('peminjam', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('alat', fn($a) => $a->where('nama_alat', 'like', "%{$search}%"));
            });
        }

        $pengembalianList = $query->latest()->get();

        // Hitungan kategori pengembalian
        $allDisetujui = Peminjaman::where('status', Peminjaman::STATUS_DISETUJUI)->get();
        $today = now()->startOfDay();

        $counts = [
            'semua'      => $allDisetujui->count(),
            'aktif'      => $allDisetujui->filter(fn($p) => !$p->isSudahDikembalikan())->count(),
            'terlambat'  => $allDisetujui->filter(fn($p) => !$p->isSudahDikembalikan() && $today->gt(Carbon::parse($p->tanggal_kembali)))->count(),
            'selesai'    => $allDisetujui->filter(fn($p) => $p->isSudahDikembalikan())->count(),
        ];

        return view('petugas.pengembalian.index', compact('pengembalianList', 'counts'));
    }

    /**
     * Petugas mencatat langsung pengembalian alat (jika peminjam menyerahkan ke petugas)
     */
    public function prosesPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        if ($peminjaman->status !== Peminjaman::STATUS_DISETUJUI) {
            return back()->with('error', 'Status peminjaman belum disetujui.');
        }

        if ($peminjaman->isSudahDikembalikan()) {
            return back()->with('info', 'Alat ini sudah tercatat dikembalikan.');
        }

        $isOverdue = Carbon::parse($peminjaman->tanggal_kembali)->isPast() && !Carbon::parse($peminjaman->tanggal_kembali)->isToday();
        $statusReturn = $isOverdue ? 'terlambat' : 'sudah_dikembalikan';

        DB::transaction(function () use ($peminjaman, $statusReturn, $isOverdue) {
            // 1. Tambah kembali stok alat
            if ($peminjaman->alat) {
                $peminjaman->alat()->increment('stok', $peminjaman->jumlah);
            }

            // 2. Catat di tabel pengembalians
            Pengembalian::create([
                'id_alat'     => $peminjaman->id_alat,
                'id_kategori' => $peminjaman->alat->id_kategori ?? 1,
                'status'      => $statusReturn,
            ]);

            // 3. Catat di peminjaman
            $note = "[DIKEMBALIKAN: " . now()->format('d/m/Y H:i') . ($isOverdue ? " - Terlambat" : " - Tepat Waktu") . " - Diverifikasi Petugas: " . Auth::user()->name . "]";
            $peminjaman->catatan = trim(($peminjaman->catatan ? $peminjaman->catatan . "\n" : "") . $note);
            $peminjaman->save();
        });

        return back()->with('success', "Pengembalian alat '{$peminjaman->alat?->nama_alat}' berhasil diverifikasi. Stok alat telah dipulihkan.");
    }

    /**
     * 4. Halaman Rekap & Filter Laporan Peminjaman
     */
    public function laporan(Request $request)
    {
        $request->validate([
            'dari'   => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $query = Peminjaman::with(['peminjam', 'petugas', 'alat.kategori']);

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pengajuan', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pengajuan', '<=', $request->sampai);
        }

        if ($request->filled('status')) {
            if ($request->status === 'dikembalikan') {
                $query->where('catatan', 'like', '%[DIKEMBALIKAN%');
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->orderBy('tanggal_pengajuan', 'desc')->get();

        return view('petugas.laporan.index', compact('peminjaman'));
    }

    /**
     * Cetak Laporan (Print Layout Bersih)
     */
    public function cetakLaporan(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'petugas', 'alat.kategori']);

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pengajuan', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pengajuan', '<=', $request->sampai);
        }

        if ($request->filled('status')) {
            if ($request->status === 'dikembalikan') {
                $query->where('catatan', 'like', '%[DIKEMBALIKAN%');
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->orderBy('tanggal_pengajuan', 'desc')->get();

        return view('petugas.laporan.cetak', compact('peminjaman'));
    }
}
