@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Ketersediaan Alat</h1>
            <p class="text-muted">Periksa stok alat sebelum mengajukan peminjaman.</p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Alat</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alat</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Ketersediaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_alat }}</td>
                                        <td>{{ $item->kategori?->nama_kategori ?? '-' }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>
                                            @if ($item->stok > 0)
                                                <span class="badge badge-success">Tersedia</span>
                                            @else
                                                <span class="badge badge-danger">Tidak tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data alat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
