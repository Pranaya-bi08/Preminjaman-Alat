@extends('layouts.master')

@section('content')
<style>
    /* Clean, Professional Design System - No AI Slop / No Gradients */
    .clean-header {
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

{{-- ================= CLEAN PAGE HEADER ================= --}}
<div class="clean-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('peminjam.dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengembalian Alat</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark" style="color: #0f172a;">Pengembalian Alat</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Pantau alat yang sedang dipinjam dan lakukan proses pengembalian alat secara mandiri.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2" style="border-radius: 6px;">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary font-weight-bold" style="border-radius: 6px;">
                <i class="mdi mdi-tools mr-1"></i> Pinjam Alat Baru
            </a>
        </div>
    </div>
</div>

{{-- ================= TABEL ALAT YANG SEDANG DIPINJAM (AKTIF) ================= --}}
<div class="clean-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Alat yang Sedang Dipinjam (Wajib Dikembalikan)</h5>
            <p class="text-muted mb-0" style="font-size: 13px;">
                Pastikan kondisi alat dalam keadaan lengkap dan baik sebelum dikembalikan.
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-clean-neutral font-13">
                {{ $pinjamanAktif->count() }} Alat Belum Dikembalikan
            </span>
        </div>
    </div>

    <div class="card-body p-4">
        @if ($pinjamanAktif->count() > 0)
            <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
                <table class="table clean-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">No</th>
                            <th>Alat yang Dipinjam</th>
                            <th>Kategori</th>
                            <th class="text-center" style="width: 90px;">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th class="text-center">Status Tenggat</th>
                            <th style="width: 170px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjamanAktif as $pinjam)
                            @php
                                $tglKembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali)->startOfDay();
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $isOverdue = $today->gt($tglKembali);
                                $diffDays = $today->diffInDays($tglKembali, false);
                            @endphp
                            <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                                <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $pinjam->alat->nama_alat ?? 'Alat #'.$pinjam->id_alat }}</div>
                                    @if ($pinjam->keperluan)
                                        <small class="text-muted">Keperluan: {{ $pinjam->keperluan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-clean-neutral">{{ $pinjam->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                                </td>
                                <td class="text-center font-weight-bold">{{ $pinjam->jumlah }} Unit</td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>
                                <td class="font-weight-bold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    @if ($isOverdue)
                                        <span class="badge badge-clean-danger">
                                            Terlambat {{ abs($diffDays) }} Hari
                                        </span>
                                    @elseif ($diffDays === 0)
                                        <span class="badge badge-clean-warning">
                                            Batas Hari Ini
                                        </span>
                                    @else
                                        <span class="badge badge-clean-success">
                                            Sisa {{ $diffDays }} Hari
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('peminjam.kembalikan', $pinjam->id) }}" method="POST" class="form-kembalikan-alat">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success px-3 font-weight-bold btn-kembalikan"
                                                data-nama="{{ $pinjam->alat->nama_alat ?? 'Alat' }}"
                                                data-jumlah="{{ $pinjam->jumlah }}"
                                                style="border-radius: 4px;">
                                            Kembalikan Alat
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="mdi mdi-check-circle-outline font-30 text-success d-block mb-2"></i>
                <h5 class="font-weight-bold text-dark">Tidak Ada Pinjaman Aktif</h5>
                <p class="text-muted mb-3" style="font-size: 14px;">
                    Semua alat yang Anda pinjam telah dikembalikan dengan lengkap, atau Anda belum memiliki peminjaman aktif.
                </p>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 6px;">
                    Cari Alat di Katalog
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ================= TABEL RIWAYAT PENGEMBALIAN ================= --}}
<div class="clean-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Riwayat Pengembalian Selesai</h5>
            <small class="text-muted">Total <strong>{{ $riwayatPengembalian->count() }}</strong> riwayat pengembalian alat yang telah tuntas</small>
        </div>
    </div>

    <div class="card-body p-4">
        @if ($riwayatPengembalian->count() > 0)
            <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
                <table class="table clean-table mb-0" id="tableRiwayatKembali">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">No</th>
                            <th>Alat</th>
                            <th>Kategori</th>
                            <th class="text-center" style="width: 80px;">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Catatan Pengembalian</th>
                            <th class="text-center" style="width: 140px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatPengembalian as $item)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold text-dark">
                                    {{ $item->alat->nama_alat ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge badge-clean-neutral">{{ $item->alat->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->catatan ?: '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-clean-success">
                                        Sudah Dikembalikan
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <small>Belum ada riwayat pengembalian selesai.</small>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#tableRiwayatKembali')) {
            $('#tableRiwayatKembali').DataTable().destroy();
        }
        $('#tableRiwayatKembali').DataTable({
            "order": [[0, "asc"]],
            "language": {
                "search": "Cari Riwayat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada riwayat"
            }
        });

        $('.form-kembalikan-alat').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var btn = $(this).find('.btn-kembalikan');
            var namaAlat = btn.data('nama');
            var jumlah = btn.data('jumlah');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Kembalikan Alat?',
                    text: "Konfirmasi pengembalian " + jumlah + " unit " + namaAlat + ".",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Kembalikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                if (confirm("Apakah Anda yakin ingin mengembalikan " + jumlah + " unit " + namaAlat + "?")) {
                    form.submit();
                }
            }
        });
    });
</script>
@endpush
