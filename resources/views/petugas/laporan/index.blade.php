@extends('layouts.master')

@section('content')


{{-- ================= CLEAN HEADER ================= --}}
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Peminjaman</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Laporan Peminjaman & Pengembalian</h3>
            <p class="text-muted mb-0">
                Rekapitulasi transaksi peminjaman alat inventaris. Filter data berdasarkan rentang waktu atau status dan cetak dokumen resmi.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-primary font-weight-bold">
                <i class="mdi mdi-printer mr-1"></i> Cetak Laporan Resmi
            </a>
        </div>
    </div>
</div>

{{-- ================= FILTER FORM ================= --}}
<div class="card mb-4">
    <div class="card-header">
        <h6 class="font-weight-bold text-dark mb-0">Filter Periode & Status Laporan</h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="dari" class="font-weight-bold text-dark">Dari Tanggal</label>
                <input type="date" name="dari" id="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="sampai" class="font-weight-bold text-dark">Sampai Tanggal</label>
                <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="status" class="font-weight-bold text-dark">Status Transaksi</label>
                <select name="status" id="status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu Verifikasi</option>
                    <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui (Aktif)</option>
                    <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Sudah Dikembalikan</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary font-weight-bold mr-2">
                    <i class="mdi mdi-filter-variant mr-1"></i> Terapkan Filter
                </button>
                @if (request()->hasAny(['dari', 'sampai', 'status']))
                    <a href="{{ route('petugas.laporan.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- ================= TABEL DATA LAPORAN ================= --}}
<div class="card">
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
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold">
                <i class="mdi mdi-printer mr-1"></i> Cetak Dokumen (PDF/Print)
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive border rounded">
            <table class="table table-hover mb-0" id="tableLaporan">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Tgl Pengajuan</th>
                        <th>Nama Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center">Jumlah</th>
                        <th>Batas Kembali</th>
                        <th class="text-center">Status</th>
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
                                <span class="badge badge-secondary">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                            <td class="font-weight-bold text-dark">
                                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-success">Dikembalikan</span>
                                @elseif ($item->status === 'menunggu')
                                    <span class="badge badge-warning text-dark">Menunggu</span>
                                @elseif ($item->status === 'disetujui')
                                    <span class="badge badge-primary">Disetujui</span>
                                @elseif ($item->status === 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($item->status) }}</span>
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
                                <div class="font-weight-bold text-dark">Tidak Ada Data Transaksi</div>
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
