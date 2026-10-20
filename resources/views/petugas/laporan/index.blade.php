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

{{-- ================= CLEAN HEADER ================= --}}
<div class="clean-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Peminjaman</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark" style="color: #0f172a;">Laporan Peminjaman & Pengembalian</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Rekapitulasi transaksi peminjaman alat inventaris. Filter data berdasarkan rentang waktu atau status dan cetak dokumen resmi.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2" style="border-radius: 6px;">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-primary font-weight-bold" style="border-radius: 6px;">
                <i class="mdi mdi-printer mr-1"></i> Cetak Laporan Resmi
            </a>
        </div>
    </div>
</div>

{{-- ================= FILTER FORM ================= --}}
<div class="clean-card mb-4">
    <div class="card-header">
        <h6 class="font-weight-bold text-dark mb-0">Filter Periode & Status Laporan</h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="dari" class="font-weight-bold text-dark" style="font-size: 13px;">Dari Tanggal</label>
                <input type="date" name="dari" id="dari" class="form-control" value="{{ request('dari') }}" style="border-radius: 6px; height: 42px;">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="sampai" class="font-weight-bold text-dark" style="font-size: 13px;">Sampai Tanggal</label>
                <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request('sampai') }}" style="border-radius: 6px; height: 42px;">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="status" class="font-weight-bold text-dark" style="font-size: 13px;">Status Transaksi</label>
                <select name="status" id="status" class="form-control" style="border-radius: 6px; height: 42px;">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu Verifikasi</option>
                    <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui (Aktif)</option>
                    <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Sudah Dikembalikan</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary font-weight-bold mr-2" style="border-radius: 6px; height: 42px;">
                    <i class="mdi mdi-filter-variant mr-1"></i> Terapkan Filter
                </button>
                @if (request()->hasAny(['dari', 'sampai', 'status']))
                    <a href="{{ route('petugas.laporan.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px; height: 42px;">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- ================= TABEL DATA LAPORAN ================= --}}
<div class="clean-card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Rekapitulasi Data Peminjaman</h5>
            <small class="text-muted">
                Ditemukan <strong>{{ $peminjaman->count() }}</strong> catatan transaksi
                @if (request('dari') || request('sampai'))
                    periode {{ request('dari') ?: 'Awal' }} s/d {{ request('sampai') ?: 'Sekarang' }}
                @endif
            </small>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 6px;">
                <i class="mdi mdi-printer mr-1"></i> Cetak Dokumen (PDF/Print)
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
            <table class="table clean-table mb-0" id="tableLaporan">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center" style="width: 80px;">Jumlah</th>
                        <th>Batas Kembali</th>
                        <th class="text-center" style="width: 140px;">Status</th>
                        <th>Petugas</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User #'.$item->id_user }}</div>
                                <small class="text-muted">{{ $item->peminjam->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? '-' }}</div>
                                <span class="badge badge-clean-neutral">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                            <td class="font-weight-bold text-dark">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-clean-success">Dikembalikan</span>
                                @elseif ($item->status === 'menunggu')
                                    <span class="badge badge-clean-warning">Menunggu</span>
                                @elseif ($item->status === 'disetujui')
                                    <span class="badge badge-clean-primary">Disetujui</span>
                                @elseif ($item->status === 'ditolak')
                                    <span class="badge badge-clean-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-clean-neutral">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->petugas->name ?? '-' }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->catatan ?: '-' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-file-document-outline font-30 d-block mb-2"></i>
                                <div class="font-weight-bold text-dark" style="font-size: 15px;">Tidak Ada Data Transaksi</div>
                                <small class="text-muted">Tidak ditemukan transaksi yang cocok dengan kriteria filter yang dipilih.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#tableLaporan')) {
            $('#tableLaporan').DataTable().destroy();
        }
        $('#tableLaporan').DataTable({
            "order": [],
            "language": {
                "search": "Cari Cepat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data laporan"
            }
        });
    });
</script>
@endpush
