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

    /* Table styling */
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

    /* Navigation Shortcut Cards */
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

{{-- ================= HEADER ================= --}}
<div class="dashboard-header">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-1">
                <span class="badge badge-clean-neutral mr-2">Peminjam</span>
                <span class="text-muted" style="font-size: 13px;">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-1" style="color: #0f172a;">Selamat Datang, {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-3" style="font-size: 14px; max-width: 650px;">
                Dashboard utama untuk memantau status peminjaman alat, memeriksa batas pengembalian, dan mengakses menu layanan peminjaman.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary font-weight-bold px-3 py-2 mr-2 mb-2" data-toggle="modal" data-target="#modalPinjamAlat" style="border-radius: 6px;">
                    <i class="mdi mdi-plus mr-1"></i> Ajukan Peminjaman
                </button>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2 mr-2 mb-2" style="border-radius: 6px;">
                    <i class="mdi mdi-format-list-bulleted mr-1"></i> Daftar & Kategori Alat
                </a>
                <a href="{{ route('peminjam.pengembalian.index') }}" class="btn btn-light border px-3 py-2 mb-2" style="border-radius: 6px; color: #475569;">
                    <i class="mdi mdi-backup-restore mr-1"></i> Pengembalian Alat
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-right">
            <div class="p-3 bg-light rounded border text-left d-inline-block" style="min-width: 240px; border-color: #e2e8f0 !important;">
                <span class="text-muted text-uppercase" style="font-size: 11px; font-weight: 600; letter-spacing: 0.05em;">Ringkasan Status</span>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span style="font-size: 13px; color: #334155;">Peminjaman Aktif</span>
                    <span class="badge badge-clean-success">{{ $stats['dipinjam_aktif'] }} Unit</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span style="font-size: 13px; color: #334155;">Menunggu Konfirmasi</span>
                    <span class="badge badge-clean-warning">{{ $stats['menunggu'] }} Pengajuan</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="row">
    <!-- Total Alat Tersedia -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Alat Tersedia</span>
                    <div class="stat-value">{{ $stats['total_alat_tersedia'] }}</div>
                    <div class="stat-desc">dari {{ $stats['total_kategori'] }} kategori alat</div>
                </div>
                <div class="stat-icon" style="background-color: #f1f5f9; color: #334155;">
                    <i class="mdi mdi-tools"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('peminjam.alat.index') }}" class="font-weight-bold" style="font-size: 12px; color: #2563eb;">
                    Buka Halaman Katalog &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Menunggu Persetujuan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Menunggu Persetujuan</span>
                    <div class="stat-value text-dark">{{ $stats['menunggu'] }}</div>
                    <div class="stat-desc">permohonan menunggu petugas</div>
                </div>
                <div class="stat-icon" style="background-color: #fffbeb; color: #b45309;">
                    <i class="mdi mdi-clock-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('peminjam.pengajuan.index') }}" class="font-weight-bold" style="font-size: 12px; color: #b45309;">
                    Halaman Pengajuan &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Sedang Dipinjam</span>
                    <div class="stat-value text-dark">{{ $stats['dipinjam_aktif'] }}</div>
                    <div class="stat-desc">alat aktif wajib dikembalikan</div>
                </div>
                <div class="stat-icon" style="background-color: #f0fdf4; color: #15803d;">
                    <i class="mdi mdi-package-variant"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('peminjam.pengembalian.index') }}" class="font-weight-bold" style="font-size: 12px; color: #15803d;">
                    Halaman Pengembalian &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Selesai Dikembalikan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-widget">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-label">Sudah Dikembalikan</span>
                    <div class="stat-value text-dark">{{ $stats['sudah_kembali'] }}</div>
                    <div class="stat-desc">total riwayat peminjaman</div>
                </div>
                <div class="stat-icon" style="background-color: #f8fafc; color: #64748b;">
                    <i class="mdi mdi-check-all"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('peminjam.pengembalian.index') }}" class="text-muted" style="font-size: 12px;">
                    Lihat Riwayat &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ================= MENU NAVIGASI TERPISAH (SHORTCUT CARDS) ================= --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.alat.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #f1f5f9; color: #1e293b;">
                        <i class="mdi mdi-view-list font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Daftar & Kategori Alat</h5>
                        <small class="text-muted">{{ $stats['total_alat_tersedia'] }} alat inventaris</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Jelajahi seluruh alat yang tersedia berdasarkan kategori dan periksa rincian stok unit.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top text-primary font-weight-bold" style="font-size: 13px;">
                Buka Halaman Alat &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.pengajuan.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #fffbeb; color: #b45309;">
                        <i class="mdi mdi-send font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Pengajuan Pinjam</h5>
                        <small class="text-muted">{{ $stats['total_pengajuan'] }} riwayat pengajuan</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Buat pengajuan baru dan pantau status persetujuan dari petugas secara terpisah.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold" style="font-size: 13px; color: #b45309;">
                Buka Halaman Pengajuan &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.pengembalian.index') }}" class="nav-shortcut-card">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon mr-3" style="background-color: #f0fdf4; color: #15803d;">
                        <i class="mdi mdi-backup-restore font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Pengembalian Alat</h5>
                        <small class="text-muted">{{ $stats['dipinjam_aktif'] }} pinjaman aktif</small>
                    </div>
                </div>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Periksa batas waktu pengembalian dan lakukan proses pengembalian alat secara mandiri.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold" style="font-size: 13px; color: #15803d;">
                Buka Halaman Pengembalian &rarr;
            </div>
        </a>
    </div>
</div>

{{-- ================= RINGKASAN AKTIVITAS TERBARU ================= --}}
<div class="row">
    <!-- Preview Alat Tersedia -->
    <div class="col-lg-6 mb-4">
        <div class="clean-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0">Alat Tersedia (Pratinjau)</h6>
                <a href="{{ route('peminjam.alat.index') }}" class="font-weight-bold" style="font-size: 12px; color: #2563eb;">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table clean-table mb-0">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alatTersediaPreview as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $item->nama_alat }}</td>
                                    <td>
                                        <span class="badge badge-clean-neutral">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td class="text-center font-weight-bold">{{ $item->stok }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary px-2 py-1 font-weight-bold btn-pinjam-cepat"
                                                data-id="{{ $item->id }}"
                                                style="border-radius: 4px; font-size: 12px;">
                                            Pinjam
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada alat tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Pengajuan Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="clean-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0">Pengajuan Terbaru</h6>
                <a href="{{ route('peminjam.pengajuan.index') }}" class="font-weight-bold" style="font-size: 12px; color: #b45309;">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table clean-table mb-0">
                        <thead>
                            <tr>
                                <th>Alat</th>
                                <th class="text-center">Jumlah</th>
                                <th>Tgl Kembali</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuanTerbaru as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $item->alat->nama_alat ?? '-' }}</td>
                                    <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        @if ($item->isSudahDikembalikan())
                                            <span class="badge badge-clean-success">Dikembalikan</span>
                                        @elseif ($item->status === 'menunggu')
                                            <span class="badge badge-clean-warning">Menunggu</span>
                                        @elseif ($item->status === 'disetujui')
                                            <span class="badge badge-clean-primary">Disetujui</span>
                                        @elseif ($item->status === 'ditolak')
                                            <span class="badge badge-clean-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL FORM PINJAM ALAT ================= --}}
<div class="modal fade" id="modalPinjamAlat" tabindex="-1" role="dialog" aria-labelledby="modalPinjamAlatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div class="modal-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <div>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalPinjamAlatLabel">Form Pengajuan Peminjaman Alat</h5>
                    <small class="text-muted">Isi formulir untuk mengajukan peminjaman alat inventaris</small>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('peminjam.pengajuan.store') }}" method="POST" id="formPinjamAlat">
                @csrf
                <div class="modal-body p-4">
                    {{-- Pilihan Alat --}}
                    <div class="form-group mb-3">
                        <label for="modal_id_alat" class="font-weight-bold text-dark" style="font-size: 13px;">
                            Pilih Alat <span class="text-danger">*</span>
                        </label>
                        <select name="id_alat" id="modal_id_alat" class="form-control" required style="border-radius: 6px; height: 42px;">
                            <option value="">-- Pilih Alat yang Tersedia --</option>
                            @foreach ($semuaAlatTersedia as $alat)
                                <option value="{{ $alat->id }}" data-stok="{{ $alat->stok }}" @selected(old('id_alat') == $alat->id)>
                                    {{ $alat->nama_alat }} (Kategori: {{ $alat->kategori->nama_kategori ?? 'Umum' }} — Sisa: {{ $alat->stok }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted" id="stokInfoBadge">Pilih alat untuk memeriksa ketersediaan.</small>
                    </div>

                    {{-- Jumlah & Tanggal Kembali --}}
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="modal_jumlah" class="font-weight-bold text-dark" style="font-size: 13px;">
                                Jumlah Unit <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="jumlah" id="modal_jumlah" class="form-control" min="1" max="100" value="{{ old('jumlah', 1) }}" required style="border-radius: 6px; height: 42px;">
                            <small class="text-muted" id="maxStokText">Minimal 1 unit</small>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="modal_tanggal_kembali" class="font-weight-bold text-dark" style="font-size: 13px;">
                                Rencana Batas Kembali <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_kembali" id="modal_tanggal_kembali" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+3 days'))) }}" required style="border-radius: 6px; height: 42px;">
                            <small class="text-muted">Tanggal batas pengembalian</small>
                        </div>
                    </div>

                    {{-- Keperluan --}}
                    <div class="form-group mb-0">
                        <label for="modal_keperluan" class="font-weight-bold text-dark" style="font-size: 13px;">
                            Keperluan Peminjaman
                        </label>
                        <textarea name="keperluan" id="modal_keperluan" rows="3" class="form-control" placeholder="Contoh: Praktikum, dokumentasi kegiatan, tugas..." style="border-radius: 6px;">{{ old('keperluan') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3" style="border-top: 1px solid #f1f5f9; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 6px;">
                        Kirim Pengajuan
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
        $(document).on('click', '.btn-pinjam-cepat', function () {
            var alatId = $(this).data('id');
            $('#modal_id_alat').val(alatId).trigger('change');
            $('#modalPinjamAlat').modal('show');
        });

        $('#modal_id_alat').on('change', function () {
            var selected = $(this).find(':selected');
            var stok = selected.data('stok');
            if (stok !== undefined && stok !== '') {
                $('#stokInfoBadge').html('<span class="text-success font-weight-bold">Tersedia: ' + stok + ' unit</span>');
                $('#modal_jumlah').attr('max', stok);
                $('#maxStokText').text('Maksimal: ' + stok + ' unit');
                if (parseInt($('#modal_jumlah').val()) > parseInt(stok)) {
                    $('#modal_jumlah').val(stok);
                }
            } else {
                $('#stokInfoBadge').text('Pilih alat untuk memeriksa ketersediaan.');
                $('#maxStokText').text('Minimal 1 unit');
                $('#modal_jumlah').removeAttr('max');
            }
        });
    });
</script>
@endpush
