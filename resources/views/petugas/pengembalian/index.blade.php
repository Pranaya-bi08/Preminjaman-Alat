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

{{-- ================= CLEAN HEADER ================= --}}
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Memantau Pengembalian</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Memantau Pengembalian Alat</h3>
            <p class="text-muted mb-0">
                Pantau status alat yang sedang dipinjam, identifikasi keterlambatan pengembalian, dan catat verifikasi alat kembali.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.laporan.index') }}" class="btn btn-light border">
                <i class="mdi mdi-printer mr-1"></i> Cetak Laporan
            </a>
        </div>
    </div>
</div>

{{-- ================= TABEL MONITORING PENGEMBALIAN ================= --}}
<div class="card">
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
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari peminjam / alat..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
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
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua Transaksi Disetujui <span class="badge badge-light">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'aktif']) }}" class="btn btn-sm {{ request('filter') === 'aktif' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Belum Dikembalikan (Aktif) <span class="badge badge-light">{{ $counts['aktif'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'terlambat']) }}" class="btn btn-sm {{ request('filter') === 'terlambat' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Terlambat <span class="badge badge-light">{{ $counts['terlambat'] }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index', ['filter' => 'selesai']) }}" class="btn btn-sm {{ request('filter') === 'selesai' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Sudah Dikembalikan <span class="badge badge-light">{{ $counts['selesai'] }}</span>
            </a>
        </div>

        {{-- Tabel Monitoring --}}
        <div class="table-responsive border rounded">
            <table class="table table-hover mb-0" id="tableMonitoring">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th class="text-center">Status Tenggat</th>
                        <th class="text-center">Status Kembali</th>
                        <th class="text-center">Aksi Petugas</th>
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
                                <span class="badge badge-secondary">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
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
                                    <span class="badge badge-secondary">Selesai</span>
                                @elseif ($isOverdue)
                                    <span class="badge badge-danger">Terlambat {{ abs($diffDays) }} Hari</span>
                                @elseif ($diffDays === 0)
                                    <span class="badge badge-warning text-dark">Batas Hari Ini</span>
                                @else
                                    <span class="badge badge-success">Sisa {{ $diffDays }} Hari</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-success">Sudah Dikembalikan</span>
                                @else
                                    <span class="badge badge-warning text-dark">Belum Dikembalikan</span>
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
                                               >
                                            <i class="mdi mdi-check mr-1"></i> Catat Kembali
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">
                                        <i class="mdi mdi-check-all mr-1 text-success"></i> Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-check-circle-outline font-30 text-success d-block mb-2"></i>
                                <div class="font-weight-bold text-dark">Tidak Ada Data Pengembalian</div>
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
                }).then(function (res) {
                    if (res.isConfirmed || res.value === true) {
                        HTMLFormElement.prototype.submit.call(form);
                    }
                });
            } else {
                if (confirm('Konfirmasi pengembalian ' + jml + ' unit ' + alat + ' oleh ' + nama + '?')) form.submit();
            }
        });
    });
</script>
@endpush
