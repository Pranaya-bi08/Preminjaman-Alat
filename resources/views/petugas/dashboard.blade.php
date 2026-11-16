@extends('layouts.master')

@section('content')


{{-- ================= ALERT NOTIFIKASI ================= --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-check-circle mr-2 font-18 text-success"></i>
            <div>
                <strong>Berhasil:</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-alert-circle mr-2 font-18 text-danger"></i>
            <div>
                <strong>Perhatian:</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- ================= CLEAN HEADER PETUGAS ================= --}}
<div class="mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-1">
                <span class="badge badge-secondary mr-2">Petugas Laboratorium / Inventaris</span>
                <span class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-1">Dashboard Petugas - {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-3">
                Kelola persetujuan peminjaman alat, pantau batas waktu pengembalian, dan cetak laporan transaksi peminjaman.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('petugas.persetujuan.index') }}" class="btn btn-primary font-weight-bold px-3 py-2 mr-2 mb-2">
                    <i class="mdi mdi-check-circle mr-1"></i> Menyetujui Peminjaman
                    @if ($stats['menunggu'] > 0)
                        <span class="badge badge-light text-dark ml-1">{{ $stats['menunggu'] }}</span>
                    @endif
                </a>
                <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2 mr-2 mb-2">
                    <i class="mdi mdi-eye mr-1"></i> Memantau Pengembalian
                </a>
                <a href="{{ route('petugas.laporan.index') }}" class="btn btn-light border px-3 py-2 mb-2">
                    <i class="mdi mdi-printer mr-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-right">
            <div class="p-3 bg-light rounded border text-left d-inline-block">
                <span class="text-muted text-uppercase">Status Antrean</span>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span>Menunggu Persetujuan</span>
                    <span class="badge {{ $stats['menunggu'] > 0 ? 'badge-warning text-dark' : 'badge-secondary' }}">
                        {{ $stats['menunggu'] }} Pengajuan
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span>Sedang Dipinjam</span>
                    <span class="badge badge-primary">{{ $stats['dipinjam_aktif'] }} Unit</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= METRIC CARDS ================= --}}
<div class="row">
    <!-- Menunggu Persetujuan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Menunggu Persetujuan</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['menunggu'] }}</div>
                    <div class="text-muted small">pengajuan butuh verifikasi</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-clock-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('petugas.persetujuan.index') }}" class="font-weight-bold">
                    Buka Halaman Persetujuan &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif (Sedang Dipinjam) -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Sedang Dipinjam</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['dipinjam_aktif'] }}</div>
                    <div class="text-muted small">alat aktif dalam peminjaman</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-package-variant"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('petugas.pengembalian.index') }}" class="font-weight-bold">
                    Pantau Pengembalian &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Selesai Dikembalikan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Selesai Dikembalikan</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['sudah_kembali'] }}</div>
                    <div class="text-muted small">transaksi peminjaman tuntas</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-check-all"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('petugas.pengembalian.index', ['filter' => 'selesai']) }}" class="text-muted font-weight-bold">
                    Lihat Riwayat &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Stok Alat Inventaris -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Stok Tersedia</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['stok_tersedia'] }}</div>
                    <div class="text-muted small">dari {{ $stats['total_alat'] }} jenis alat inventaris</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-cube-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <span class="text-muted">Total Transaksi: {{ $stats['total_transaksi'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ================= 3 SHORTCUT MENU PETUGAS ================= --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.persetujuan.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-check-circle font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Menyetujui Peminjaman</h5>
                        <small class="text-muted">{{ $stats['menunggu'] }} permohonan antre</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Tinjau rincian pengajuan alat dari peminjam, setujui atau tolak permohonan dengan catatan resmi.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold">
                Buka Halaman Persetujuan &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.pengembalian.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-eye font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Memantau Pengembalian</h5>
                        <small class="text-muted">{{ $stats['dipinjam_aktif'] }} alat sedang dipinjam</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Pantau batas waktu pengembalian alat, deteksi keterlambatan, dan catat verifikasi pengembalian.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold">
                Buka Halaman Pengembalian &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.laporan.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-printer font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Mencetak Laporan</h5>
                        <small class="text-muted">Rekapitulasi transaksi lengkap</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Filter laporan peminjaman dan pengembalian berdasarkan rentang tanggal dan cetak dokumen resmi.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top text-primary font-weight-bold">
                Buka Halaman Laporan &rarr;
            </div>
        </a>
    </div>
</div>

{{-- ================= TABEL PENGAJUAN BUTUH TINDAKAN ================= --}}
<div class="row">
    <!-- Antrean Pengajuan Menunggu -->
    <div class="col-lg-7 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="font-weight-bold text-dark mb-0">Pengajuan Butuh Tindakan (Antrean Menunggu)</h6>
                    <small class="text-muted">Tinjau permohonan pinjam alat terbaru</small>
                </div>
                <a href="{{ route('petugas.persetujuan.index') }}" class="font-weight-bold">
                    Lihat Semua ({{ $stats['menunggu'] }}) &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th class="text-center">Jml</th>
                                <th>Tenggat Pengembalian</th>
                                <th class="text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($antreanMenunggu as $item)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User #'.$item->id_user }}</div>
                                        <small class="text-muted">{{ $item->peminjam->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? '-' }}</div>
                                        <small class="text-muted">Stok: {{ $item->alat->stok ?? 0 }}</small>
                                    </td>
                                    <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>
                                    <td class="text-muted">Ditentukan saat disetujui</td>
                                    <td class="text-center">
                                        <a href="{{ route('petugas.persetujuan.index', ['status' => 'menunggu']) }}" class="btn btn-sm btn-success px-2 py-1" title="Atur tenggat dan setujui">
                                            <i class="mdi mdi-check"></i> Proses
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 ml-1 btn-tolak-modal" 
                                                data-id="{{ $item->id }}" 
                                                data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}" 
                                                data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                                title="Tolak">
                                            <i class="mdi mdi-close"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="mdi mdi-check-circle-outline font-22 text-success d-block mb-1"></i>
                                        Tidak ada pengajuan yang menunggu persetujuan saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif yang Perlu Dipantau -->
    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="font-weight-bold text-dark mb-0">Peminjaman Aktif</h6>
                    <small class="text-muted">Masa pinjaman sedang berjalan</small>
                </div>
                <a href="{{ route('petugas.pengembalian.index') }}" class="font-weight-bold">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam & Alat</th>
                                <th>Batas Kembali</th>
                                <th class="text-center">Tenggat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($perluDipantau as $item)
                                @php
                                    $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                                    $today = \Carbon\Carbon::now()->startOfDay();
                                    $isOverdue = $today->gt($tglKembali);
                                    $diffDays = $today->diffInDays($tglKembali, false);
                                @endphp
                                <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User' }}</div>
                                        <small class="text-muted">{{ $item->alat->nama_alat ?? 'Alat' }} ({{ $item->jumlah }} unit)</small>
                                    </td>
                                    <td class="font-weight-bold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($isOverdue)
                                            <span class="badge badge-danger">Terlambat {{ abs($diffDays) }} H</span>
                                        @elseif ($diffDays === 0)
                                            <span class="badge badge-warning text-dark">Hari Ini</span>
                                        @else
                                            <span class="badge badge-success">Sisa {{ $diffDays }} H</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Tidak ada peminjaman aktif.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Penolakan --}}
<div class="modal fade" id="modalTolakPengajuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title font-weight-bold text-dark" id="modalTolakTitle">Tolak Pengajuan Peminjaman</h5>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="formTolakPengajuan">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3" id="textKonfirmasiTolak">
                        Masukkan alasan penolakan agar peminjam dapat mengetahui penyebab permohonan tidak disetujui.
                    </p>
                    <div class="form-group mb-0">
                        <label for="catatan_tolak" class="font-weight-bold text-dark">
                            Alasan / Catatan Penolakan
                        </label>
                        <textarea name="catatan" id="catatan_tolak" rows="3" class="form-control" placeholder="Contoh: Alat sedang dalam masa perbaikan, stok fisik tidak tersedia..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Buka modal tolak
        $('.btn-tolak-modal').on('click', function () {
            var id = $(this).data('id');
            var peminjam = $(this).data('peminjam');
            var alat = $(this).data('alat');

            $('#textKonfirmasiTolak').text('Anda akan menolak pengajuan alat ' + alat + ' oleh ' + peminjam + '.');
            $('#formTolakPengajuan').attr('action', '/petugas/persetujuan/' + id + '/tolak');
            $('#modalTolakPengajuan').modal('show');
        });
    });
</script>
@endpush
