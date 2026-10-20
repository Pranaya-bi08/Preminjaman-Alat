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
                    <li class="breadcrumb-item active" aria-current="page">Menyetujui Peminjaman</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark" style="color: #0f172a;">Menyetujui & Menolak Peminjaman</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Tinjau permohonan pinjam alat dari peminjam, setujui untuk memotong stok alat atau tolak dengan alasan resmi.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2" style="border-radius: 6px;">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-light border" style="border-radius: 6px; color: #475569;">
                <i class="mdi mdi-eye mr-1"></i> Pantau Pengembalian
            </a>
        </div>
    </div>
</div>

{{-- ================= TAB FILTER & TABEL PERSETUJUAN ================= --}}
<div class="clean-card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Daftar Permohonan Peminjaman</h5>
            <small class="text-muted">Total <strong>{{ $peminjamanList->count() }}</strong> permohonan dalam daftar</small>
        </div>
        <div class="mt-2 mt-md-0">
            <form action="{{ route('petugas.persetujuan.index') }}" method="GET" class="d-flex align-items-center">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
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
        {{-- Filter Status Tabs --}}
        <div class="mb-3">
            <a href="{{ route('petugas.persetujuan.index') }}" class="filter-pill {{ !request('status') ? 'active' : '' }}">
                Semua Permohonan <span class="pill-number">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'menunggu']) }}" class="filter-pill {{ request('status') === 'menunggu' ? 'active' : '' }}">
                Menunggu Verifikasi <span class="pill-number">{{ $counts['menunggu'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'disetujui']) }}" class="filter-pill {{ request('status') === 'disetujui' ? 'active' : '' }}">
                Disetujui <span class="pill-number">{{ $counts['disetujui'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'dikembalikan']) }}" class="filter-pill {{ request('status') === 'dikembalikan' ? 'active' : '' }}">
                Dikembalikan <span class="pill-number">{{ $counts['dikembalikan'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'ditolak']) }}" class="filter-pill {{ request('status') === 'ditolak' ? 'active' : '' }}">
                Ditolak <span class="pill-number">{{ $counts['ditolak'] }}</span>
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
            <table class="table clean-table mb-0" id="tablePersetujuan">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center">Jml (Sisa Stok)</th>
                        <th>Tgl Pengajuan</th>
                        <th>Batas Kembali</th>
                        <th>Keperluan</th>
                        <th class="text-center" style="width: 130px;">Status</th>
                        <th class="text-center" style="width: 170px;">Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanList as $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User #'.$item->id_user }}</div>
                                <small class="text-muted">{{ $item->peminjam->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? 'Alat #' . $item->id_alat }}</div>
                                <span class="badge badge-clean-neutral">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="font-weight-bold font-15">{{ $item->jumlah }} Unit</span>
                                <small class="d-block text-muted">(Sisa: {{ $item->alat->stok ?? 0 }})</small>
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                            </td>
                            <td class="font-weight-bold text-dark">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                            </td>
                            <td class="text-muted" style="max-width: 180px;">
                                {{ $item->keperluan ?: '-' }}
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

                                @if ($item->catatan)
                                    <small class="d-block text-muted font-italic mt-1" style="font-size: 11px;">
                                        Catatan: {{ Str::limit($item->catatan, 35) }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status === 'menunggu')
                                    <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST" class="d-inline form-setujui-row">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1 font-weight-bold" title="Setujui Peminjaman" style="border-radius: 4px;">
                                            <i class="mdi mdi-check mr-1"></i> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 font-weight-bold btn-tolak-row" 
                                            data-id="{{ $item->id }}" 
                                            data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}" 
                                            data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                            title="Tolak Peminjaman" style="border-radius: 4px;">
                                        <i class="mdi mdi-close mr-1"></i> Tolak
                                    </button>
                                @else
                                    <span class="text-muted" style="font-size: 12px;">
                                        <i class="mdi mdi-check-all mr-1"></i> Selesai Diproses
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-clipboard-text-outline font-30 d-block mb-2"></i>
                                <div class="font-weight-bold text-dark" style="font-size: 15px;">Tidak Ada Data Permohonan</div>
                                <small class="text-muted">Tidak ditemukan data yang sesuai dengan status filter saat ini.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Penolakan --}}
<div class="modal fade" id="modalTolakPengajuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <div class="modal-header bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 16px 20px;">
                <h5 class="modal-title font-weight-bold text-dark">Tolak Permohonan Peminjaman</h5>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="formTolakModal">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3" id="textKonfirmasiTolakModal">
                        Masukkan alasan penolakan agar peminjam dapat mengetahui penyebab permohonan tidak disetujui.
                    </p>
                    <div class="form-group mb-0">
                        <label for="catatan_tolak_field" class="font-weight-bold text-dark" style="font-size: 13px;">
                            Alasan / Catatan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea name="catatan" id="catatan_tolak_field" rows="3" class="form-control" placeholder="Contoh: Alat sedang dalam perawatan, alat telah dipesan oleh kelas lain..." required style="border-radius: 6px;"></textarea>
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
        if ($.fn.DataTable.isDataTable('#tablePersetujuan')) {
            $('#tablePersetujuan').DataTable().destroy();
        }
        $('#tablePersetujuan').DataTable({
            "order": [],
            "language": {
                "search": "Cari Cepat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data peminjaman"
            }
        });

        // Konfirmasi Setujui
        $('.form-setujui-row').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Setujui Peminjaman?',
                    text: 'Stok alat akan otomatis berkurang sesuai jumlah yang diminta.',
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
                if (confirm('Setujui peminjaman ini? Stok alat akan berkurang.')) form.submit();
            }
        });

        // Buka modal tolak
        $(document).on('click', '.btn-tolak-row', function () {
            var id = $(this).data('id');
            var peminjam = $(this).data('peminjam');
            var alat = $(this).data('alat');

            $('#textKonfirmasiTolakModal').text('Anda akan menolak pengajuan alat "' + alat + '" dari ' + peminjam + '.');
            $('#formTolakModal').attr('action', '/petugas/persetujuan/' + id + '/tolak');
            $('#modalTolakPengajuan').modal('show');
        });
    });
</script>
@endpush
