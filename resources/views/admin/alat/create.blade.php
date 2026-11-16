@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Alat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('alat.index') }}">Alat</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Alat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Alat</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('alat.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select
                                        class="form-control @error('id_kategori') is-invalid @enderror"
                                        name="id_kategori"
                                        id="id_kategori"
                                        required
                                    >
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($kategori->isEmpty())
                                        <small class="form-text text-muted">
                                            Belum ada kategori. Tambahkan kategori sebelum membuat data alat.
                                        </small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="nama_alat" class="form-label">Nama Alat</label>
                                    <input
                                        type="text"
                                        class="form-control @error('nama_alat') is-invalid @enderror"
                                        name="nama_alat"
                                        id="nama_alat"
                                        value="{{ old('nama_alat') }}"
                                        maxlength="255"
                                        required
                                    >
                                    @error('nama_alat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input
                                        type="number"
                                        class="form-control @error('stok') is-invalid @enderror"
                                        name="stok"
                                        id="stok"
                                        value="{{ old('stok', 0) }}"
                                        min="0"
                                        required
                                    >
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary" type="submit" {{ $kategori->isEmpty() ? 'disabled' : '' }}>Simpan</button>
                                <a class="btn btn-warning" href="{{ route('alat.index') }}">Kembali ke Halaman Alat</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection