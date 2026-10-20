@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Kategori</h2>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Stok Alat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->alat_sum_stok ?? 0 }}</td>
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
                    <td colspan="4" class="text-center">Belum ada data kategori</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
