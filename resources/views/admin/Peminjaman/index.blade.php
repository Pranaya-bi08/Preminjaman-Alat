@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="font-medium mb-1"> Peminjaman Alat</h3>
                <p class="text-muted mb-0">Periksa pengajuan peminjam </p>
            </div>
        </div>
    </div>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

{{-- ================= RINGKASAN STATUS ================= --}}
<div class="row">
    <div class="col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="m-b-0 font-light">{{ $peminjaman->where('status', 'menunggu')->count() }}</h2>
                        <h6 class="text-muted">Menunggu</h6>
                    </div>
                    <div class="ml-auto">
                        <div class="btn btn-circle btn-outline-secondary">
                            <i class="mdi mdi-clock-outline font-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="m-b-0 font-light">{{ $peminjaman->where('status', 'disetujui')->count() }}</h2>
                        <h6 class="text-muted">Disetujui</h6>
                    </div>
                    <div class="ml-auto">
                        <div class="btn btn-circle btn-outline-success">
                            <i class="mdi mdi-check font-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="m-b-0 font-light">{{ $peminjaman->where('status', 'ditolak')->count() }}</h2>
                        <h6 class="text-muted">Ditolak</h6>
                    </div>
                    <div class="ml-auto">
                        <div class="btn btn-circle btn-outline-danger">
                            <i class="mdi mdi-close font-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pengajuan</h4>
                <p class="card-subtitle">Semua pengajuan peminjaman alat dari peminjam.</p>

                <div class="table-responsive">
                    <table id="peminjamanTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Alat</th>
                                <th>Kategori</th>
                                <th>Peminjam</th>
                                <th>Diajukan</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $item->alat->nama_alat }}</span>
                                    </td>
                                    <td>{{ $item->alat->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $item->peminjam->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('j M Y') }}</td>
                                    <td>
                                        @switch($item->status)
                                            @case('menunggu')
                                                <span class="badge badge-warning">Menunggu</span>
                                                @break
                                            @case('disetujui')
                                                <span class="badge badge-success">Disetujui</span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                    <td>
                        <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada pengajuan peminjaman alat.
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#peminjamanTable').DataTable({
            "order": [],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" }
            }
        });
    });
</script>
@endpush
