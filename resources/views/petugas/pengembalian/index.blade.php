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

    /* Filter Pills */
    .filter-pill {
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        margin-right: 6px;
        margin-bottom: 8px;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        transition: border-color 0.15s, background-color 0.15s, color 0.15s;
    }
    .filter-pill:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .filter-pill.active {
        background-color: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .filter-pill .pill-number {
        background-color: rgba(0, 0, 0, 0.06);
        border-radius: 4px;
        padding: 1px 6px;
        font-size: 11px;
        margin-left: 6px;
    }
    .filter-pill.active .pill-number {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
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

{{-- ================= CLEAN HEADER ================= --}}
<div class="clean-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Memantau Pengembalian</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark" style="color: #0f172a;">Memantau Pengembalian Alat</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Pantau status alat yang sedang dipinjam, identifikasi keterlambatan pengembalian, dan catat verifikasi alat kembali.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2" style="border-radius: 6px;">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.laporan.index') }}" class="btn btn-light border" style="border-radius: 6px; color: #475569;">
                <i class="mdi mdi-printer mr-1"></i> Cetak Laporan
            </a>
        </div>
    </div>
</div>

{{-- ================= TABEL MONITORING PENGEMBALIAN ================= --}}
<div class="clean-card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Status Pengembalian Alat Inventaris</h5>
            <small class="text-muted">Total <strong>{{ $pengembalianList->count() }}</strong> data peminjaman terpantau</small>
        </div>
        <div class="mt-2 mt-md-0">
            <form action="{{ route('petugas.pengembalian.index') }}" method="GET" class="d-flex align-items-center">
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div class="input-group" style="max-width: 260px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari peminjam / alat..." value="{{ request('search') }}" style="border-radius: 6px 0 0 6px; font-size: 13px;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" style="border-radius: 0 6px 6px 0;">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-4">
        {{-- Filter Tabs --}}
        <div class="mb-3">
            <a href="{{ route('petugas.pengembalian.index') }}" class="filter-pill {{ !request('filter') ? 'active' : '' }}">
                Semua Transaksi Disetujui <span class="pill-number">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'aktif']) }}" class="filter-pill {{ request('filter') === 'aktif' ? 'active' : '' }}">
                Belum Dikembalikan (Aktif) <span class="pill-number">{{ $counts['aktif'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'terlambat']) }}" class="filter-pill {{ request('filter') === 'terlambat' ? 'active' : '' }}">
                Terlambat <span class="pill-number">{{ $counts['terlambat'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'selesai']) }}" class="filter-pill {{ request('filter') === 'selesai' ? 'active' : '' }}">
                Sudah Dikembalikan <span class="pill-number">{{ $counts['selesai'] }}</span>
            </a>
        </div>

        {{-- Tabel Monitoring --}}
        <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
            <table class="table clean-table mb-0" id="tableMonitoring">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center" style="width: 80px;">Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th class="text-center" style="width: 140px;">Status Tenggat</th>
                        <th class="text-center" style="width: 140px;">Status Kembali</th>
                        <th class="text-center" style="width: 170px;">Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalianList as $item)
                        @php
                            $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                            $today = \Carbon\Carbon::now()->startOfDay();
                            $isOverdue = $today->gt($tglKembali) && !$item->isSudahDikembalikan();
                            $diffDays = $today->diffInDays($tglKembali, false);
                        @endphp
                        <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User #'.$item->id_user }}</div>
                                <small class="text-muted">{{ $item->peminjam->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? '-' }}</div>
                                <span class="badge badge-clean-neutral">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                            </td>
                            <td class="font-weight-bold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-clean-neutral">Selesai</span>
                                @elseif ($isOverdue)
                                    <span class="badge badge-clean-danger">Terlambat {{ abs($diffDays) }} Hari</span>
                                @elseif ($diffDays === 0)
                                    <span class="badge badge-clean-warning">Batas Hari Ini</span>
                                @else
                                    <span class="badge badge-clean-success">Sisa {{ $diffDays }} Hari</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-clean-success">Sudah Dikembalikan</span>
                                @else
                                    <span class="badge badge-clean-warning">Belum Dikembalikan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!$item->isSudahDikembalikan())
                                    <form action="{{ route('petugas.pengembalian.proses', $item->id) }}" method="POST" class="form-proses-kembali">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success px-2 py-1 font-weight-bold"
                                                data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}"
                                                data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                                data-jumlah="{{ $item->jumlah }}"
                                                style="border-radius: 4px;">
                                            <i class="mdi mdi-check mr-1"></i> Catat Kembali
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted" style="font-size: 12px;">
                                        <i class="mdi mdi-check-all mr-1 text-success"></i> Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-check-circle-outline font-30 text-success d-block mb-2"></i>
                                <div class="font-weight-bold text-dark" style="font-size: 15px;">Tidak Ada Data Pengembalian</div>
                                <small class="text-muted">Tidak ditemukan data yang sesuai dengan filter ini.</small>
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
        if ($.fn.DataTable.isDataTable('#tableMonitoring')) {
            $('#tableMonitoring').DataTable().destroy();
        }
        $('#tableMonitoring').DataTable({
            "order": [],
            "language": {
                "search": "Cari Cepat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data pengembalian"
            }
        });

        $('.form-proses-kembali').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var btn = $(this).find('button');
            var nama = btn.data('peminjam');
            var alat = btn.data('alat');
            var jml = btn.data('jumlah');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Verifikasi Pengembalian?',
                    text: 'Konfirmasi bahwa ' + nama + ' telah mengembalikan ' + jml + ' unit ' + alat + '. Stok alat akan otomatis dipulihkan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Verifikasi Pengembalian',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) form.submit();
                });
            } else {
                if (confirm('Konfirmasi pengembalian ' + jml + ' unit ' + alat + ' oleh ' + nama + '?')) form.submit();
            }
        });
    });
</script>
@endpush
