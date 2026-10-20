@extends('layouts.master')

@section('content')
<style>
    /* Clean, Professional Design System - No AI Slop / No Gradients */
    .dashboard-header {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 24px 28px;
        margin-bottom: 24px;
    }
    .clean-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: none;
        margin-bottom: 24px;
    }
    .clean-card .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .stat-widget {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-widget .stat-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
    }
    .stat-widget .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin: 6px 0 2px 0;
        line-height: 1.2;
    }
    .stat-widget .stat-desc {
        font-size: 13px;
        color: #64748b;
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    /* Clean Badges */
    .badge-clean-primary {
        background-color: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #dbeafe;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .badge-clean-success {
        background-color: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .badge-clean-warning {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .badge-clean-danger {
        background-color: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .badge-clean-neutral {
        background-color: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 4px;
    }

    /* Clean Table */
    .clean-table thead th {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 16px;
    }
    .clean-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #1e293b;
        font-size: 14px;
    }
    .clean-table tbody tr:hover {
        background-color: #fbfcfe;
    }

    /* Shortcut Card */
    .nav-shortcut-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #ffffff;
        padding: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none !important;
        transition: border-color 0.15s;
    }
    .nav-shortcut-card:hover {
        border-color: #94a3b8;
    }
</style>

{{-- ================= ALERT NOTIFIKASI ================= --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 6px; border-left: 4px solid #16a34a;">
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
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 6px; border-left: 4px solid #dc2626;">
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
<div class="dashboard-header">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-1">
                <span class="badge badge-clean-neutral mr-2">Petugas Laboratorium / Inventaris</span>
                <span class="text-muted" style="font-size: 13px;">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-1" style="color: #0f172a;">Dashboard Petugas - {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-3" style="font-size: 14px; max-width: 650px;">
                Kelola persetujuan peminjaman alat, pantau batas waktu pengembalian, dan cetak laporan transaksi peminjaman.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('petugas.persetujuan.index') }}" class="btn btn-primary font-weight-bold px-3 py-2 mr-2 mb-2" style="border-radius: 6px;">
                    <i class="mdi mdi-check-circle mr-1"></i> Menyetujui Peminjaman
                    @if ($stats['menunggu'] > 0)
                        <span class="badge badge-light text-dark ml-1">{{ $stats['menunggu'] }}</span>
                    @endif
                </a>
                <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2 mr-2 mb-2" style="border-radius: 6px;">
                    <i class="mdi mdi-eye mr-1"></i> Memantau Pengembalian
                </a>
                <a href="{{ route('petugas.laporan.index') }}" class="btn btn-light border px-3 py-2 mb-2" style="border-radius: 6px; color: #475569;">
                    <i class="mdi mdi-printer mr-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-right">
            <div class="p-3 bg-light rounded border text-left d-inline-block" style="min-width: 240px; border-color: #e2e8f0 !important;">
                <span class="text-muted text-uppercase" style="font-size: 11px; font-weight: 600; letter-spacing: 0.05em;">Status Antrean</span>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span style="font-size: 13px; color: #334155;">Menunggu Persetujuan</span>
                    <span class="badge {{ $stats['menunggu'] > 0 ? 'badge-clean-warning' : 'badge-clean-neutral' }}">
                        {{ $stats['menunggu'] }} Pengajuan
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span style="font-size: 13px; color: #334155;">Sedang Dipinjam</span>
                    <span class="badge badge-clean-primary">{{ $stats['dipinjam_aktif'] }} Unit</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= METRIC CARDS ================= --}}
<div class="row">
    <!-- Menunggu Persetujuan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Menunggu Persetujuan</span>
                    <div class="stat-value text-dark">{{ $stats['menunggu'] }}</div>
                    <div class="stat-desc">pengajuan butuh verifikasi</div>
                </div>
                <div class="stat-icon" style="background-color: #fffbeb; color: #b45309;">
                    <i class="mdi mdi-clock-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('petugas.persetujuan.index') }}" class="font-weight-bold" style="font-size: 12px; color: #b45309;">
                    Buka Halaman Persetujuan &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif (Sedang Dipinjam) -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Sedang Dipinjam</span>
                    <div class="stat-value text-dark">{{ $stats['dipinjam_aktif'] }}</div>
                    <div class="stat-desc">alat aktif dalam peminjaman</div>
                </div>
                <div class="stat-icon" style="background-color: #eff6ff; color: #1d4ed8;">
                    <i class="mdi mdi-package-variant"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('petugas.pengembalian.index') }}" class="font-weight-bold" style="font-size: 12px; color: #1d4ed8;">
                    Pantau Pengembalian &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Selesai Dikembalikan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Selesai Dikembalikan</span>
                    <div class="stat-value text-dark">{{ $stats['sudah_kembali'] }}</div>
                    <div class="stat-desc">transaksi peminjaman tuntas</div>
                </div>
                <div class="stat-icon" style="background-color: #f0fdf4; color: #15803d;">
                    <i class="mdi mdi-check-all"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('petugas.pengembalian.index', ['filter' => 'selesai']) }}" class="text-muted font-weight-bold" style="font-size: 12px;">
                    Lihat Riwayat &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Stok Alat Inventaris -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Stok Tersedia</span>
                    <div class="stat-value text-dark">{{ $stats['stok_tersedia'] }}</div>
                    <div class="stat-desc">dari {{ $stats['total_alat'] }} jenis alat inventaris</div>
                </div>
                <div class="stat-icon" style="background-color: #f8fafc; color: #475569;">
                    <i class="mdi mdi-cube-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <span class="text-muted" style="font-size: 12px;">Total Transaksi: {{ $stats['total_transaksi'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ================= 3 SHORTCUT MENU PETUGAS ================= --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.persetujuan.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #fffbeb; color: #b45309;">
                        <i class="mdi mdi-check-circle font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Menyetujui Peminjaman</h5>
                        <small class="text-muted">{{ $stats['menunggu'] }} permohonan antre</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Tinjau rincian pengajuan alat dari peminjam, setujui atau tolak permohonan dengan catatan resmi.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold" style="font-size: 13px; color: #b45309;">
                Buka Halaman Persetujuan &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.pengembalian.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #eff6ff; color: #1d4ed8;">
                        <i class="mdi mdi-eye font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Memantau Pengembalian</h5>
                        <small class="text-muted">{{ $stats['dipinjam_aktif'] }} alat sedang dipinjam</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Pantau batas waktu pengembalian alat, deteksi keterlambatan, dan catat verifikasi pengembalian.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold" style="font-size: 13px; color: #1d4ed8;">
                Buka Halaman Pengembalian &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('petugas.laporan.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #f1f5f9; color: #334155;">
                        <i class="mdi mdi-printer font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Mencetak Laporan</h5>
                        <small class="text-muted">Rekapitulasi transaksi lengkap</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Filter laporan peminjaman dan pengembalian berdasarkan rentang tanggal dan cetak dokumen resmi.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top text-primary font-weight-bold" style="font-size: 13px;">
                Buka Halaman Laporan &rarr;
            </div>
        </a>
    </div>
</div>

{{-- ================= TABEL PENGAJUAN BUTUH TINDAKAN ================= --}}
<div class="row">
    <!-- Antrean Pengajuan Menunggu -->
    <div class="col-lg-7 mb-4">
        <div class="clean-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="font-weight-bold text-dark mb-0">Pengajuan Butuh Tindakan (Antrean Menunggu)</h6>
                    <small class="text-muted">Tinjau permohonan pinjam alat terbaru</small>
                </div>
                <a href="{{ route('petugas.persetujuan.index') }}" class="font-weight-bold" style="font-size: 12px; color: #b45309;">
                    Lihat Semua ({{ $stats['menunggu'] }}) &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table clean-table mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th class="text-center">Jml</th>
                                <th>Batas Kembali</th>
                                <th class="text-center" style="width: 140px;">Aksi Cepat</th>
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
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST" class="d-inline form-setujui">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="Setujui" style="border-radius: 4px;">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 ml-1 btn-tolak-modal" 
                                                data-id="{{ $item->id }}" 
                                                data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}" 
                                                data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                                title="Tolak" style="border-radius: 4px;">
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
        <div class="clean-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="font-weight-bold text-dark mb-0">Peminjaman Aktif</h6>
                    <small class="text-muted">Masa pinjaman sedang berjalan</small>
                </div>
                <a href="{{ route('petugas.pengembalian.index') }}" class="font-weight-bold" style="font-size: 12px; color: #1d4ed8;">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table clean-table mb-0">
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
                                            <span class="badge badge-clean-danger">Terlambat {{ abs($diffDays) }} H</span>
                                        @elseif ($diffDays === 0)
                                            <span class="badge badge-clean-warning">Hari Ini</span>
                                        @else
                                            <span class="badge badge-clean-success">Sisa {{ $diffDays }} H</span>
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
        <div class="modal-content" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <div class="modal-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
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
                        <label for="catatan_tolak" class="font-weight-bold text-dark" style="font-size: 13px;">
                            Alasan / Catatan Penolakan
                        </label>
                        <textarea name="catatan" id="catatan_tolak" rows="3" class="form-control" placeholder="Contoh: Alat sedang dalam masa perbaikan, stok fisik tidak tersedia..." style="border-radius: 6px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3" style="border-top: 1px solid #f1f5f9; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" style="border-radius: 6px;">
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
        // Konfirmasi Setujui
        $('.form-setujui').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Setujui Peminjaman?',
                    text: 'Stok alat akan dikurangi sesuai jumlah unit peminjaman.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) form.submit();
                });
            } else {
                if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) form.submit();
            }
        });

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
