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

{{-- ================= CLEAN PAGE HEADER ================= --}}
<div class="clean-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('peminjam.dashboard') }}" style="color: #2563eb;">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Pinjam</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark" style="color: #0f172a;">Pengajuan Peminjaman Alat</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Kelola seluruh permohonan peminjaman alat inventaris dan pantau status persetujuan dari petugas.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2" style="border-radius: 6px;">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#modalPinjamAlat" style="border-radius: 6px;">
                <i class="mdi mdi-plus mr-1"></i> Ajukan Peminjaman Baru
            </button>
        </div>
    </div>
</div>

{{-- ================= FILTER STATUS & TABEL PENGAJUAN ================= --}}
<div class="clean-card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Daftar Pengajuan Peminjaman</h5>
            <small class="text-muted">Total <strong>{{ $pengajuanList->count() }}</strong> permohonan ditampilkan</small>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 6px;">
                <i class="mdi mdi-tools mr-1"></i> Cek Stok di Katalog
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        {{-- Filter Status Tabs --}}
        <div class="mb-3">
            <a href="{{ route('peminjam.pengajuan.index') }}" class="filter-pill {{ !request('status') ? 'active' : '' }}">
                Semua Status <span class="pill-number">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'menunggu']) }}" class="filter-pill {{ request('status') === 'menunggu' ? 'active' : '' }}">
                Menunggu <span class="pill-number">{{ $counts['menunggu'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'disetujui']) }}" class="filter-pill {{ request('status') === 'disetujui' ? 'active' : '' }}">
                Disetujui <span class="pill-number">{{ $counts['disetujui'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'dikembalikan']) }}" class="filter-pill {{ request('status') === 'dikembalikan' ? 'active' : '' }}">
                Dikembalikan <span class="pill-number">{{ $counts['dikembalikan'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'ditolak']) }}" class="filter-pill {{ request('status') === 'ditolak' ? 'active' : '' }}">
                Ditolak <span class="pill-number">{{ $counts['ditolak'] }}</span>
            </a>
        </div>

        {{-- Tabel Pengajuan --}}
        <div class="table-responsive border rounded" style="border-color: #e2e8f0 !important;">
            <table class="table clean-table mb-0" id="tablePengajuanFull">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Alat yang Diajukan</th>
                        <th>Kategori</th>
                        <th class="text-center" style="width: 80px;">Jumlah</th>
                        <th>Tgl Pengajuan</th>
                        <th>Batas Kembali</th>
                        <th>Keperluan</th>
                        <th class="text-center" style="width: 140px;">Status</th>
                        <th>Catatan Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuanList as $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? 'Alat #' . $item->id_alat }}</div>
                                <small class="text-muted">ID: #PGJ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-clean-neutral">{{ $item->alat->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                            </td>
                            <td class="font-weight-bold">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                            </td>
                            <td class="text-muted" style="max-width: 200px;">
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
                            </td>
                            <td>
                                @if ($item->catatan)
                                    <small class="text-muted font-italic">{{ $item->catatan }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-clipboard-text-outline font-30 d-block mb-2"></i>
                                <div class="font-weight-bold text-dark" style="font-size: 15px;">Belum Ada Pengajuan</div>
                                <small class="text-muted">Klik tombol "Ajukan Peminjaman Baru" untuk memulai permohonan pinjam alat.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= CLEAN MODAL PINJAM ALAT ================= --}}
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
        if ($.fn.DataTable.isDataTable('#tablePengajuanFull')) {
            $('#tablePengajuanFull').DataTable().destroy();
        }
        $('#tablePengajuanFull').DataTable({
            "order": [[0, "asc"]],
            "language": {
                "search": "Cari Pengajuan:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ pengajuan",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data pengajuan"
            }
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
