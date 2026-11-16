@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="font-medium mb-1">Pengembalian Alat</h3>
                <p class="text-muted mb-0">Pantau status pengembalian alat.</p>
            </div>
            <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Tambah Pengembalian
            </a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">&times;</button>
    </div>
@endif

<div class="row">
    @foreach ([
        'belum_dikembalikan' => ['Belum Dikembalikan', 'warning', 'clock-outline'],
        'sudah_dikembalikan' => ['Sudah Dikembalikan', 'success', 'check'],
        'terlambat' => ['Terlambat', 'danger', 'alert-circle'],
    ] as $status => [$label, $color, $icon])
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="m-b-0 font-light">{{ $pengembalian->where('status', $status)->count() }}</h2>
                            <h6 class="text-muted">{{ $label }}</h6>
                        </div>
                        <div class="ml-auto">
                            <div class="btn btn-circle btn-outline-{{ $color }}">
                                <i class="mdi mdi-{{ $icon }} font-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pengembalian</h4>
                <p class="card-subtitle">Data alat dan status pengembaliannya.</p>

                <div class="table-responsive">
                    <table id="pengembalianTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Alat</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Dicatat</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalian as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                                    <td>{{ $item->kategori->nama_kategori ?? $item->alat->kategori->nama_kategori ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusLabels = [
                                                'belum_dikembalikan' => ['Belum Dikembalikan', 'warning'],
                                                'sudah_dikembalikan' => ['Sudah Dikembalikan', 'success'],
                                                'terlambat' => ['Terlambat', 'danger'],
                                            ];
                                            [$statusLabel, $statusColor] = $statusLabels[$item->status] ?? [$item->status, 'secondary'];
                                        @endphp
                                        <span class="badge badge-{{ $statusColor }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('pengembalian.edit', $item) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('pengembalian.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data pengembalian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data pengembalian.
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
        $('#pengembalianTable').DataTable({
            "order": [],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data pengembalian"
            }
        });
    });
</script>
@endpush