@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('kategori.index') }}">Kategori</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Kategori</li>
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
                            <h3 class="card-title">Form Kategori</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kategori.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                    <input
                                        type="text"
                                        class="form-control @error('nama_kategori') is-invalid @enderror"
                                        name="nama_kategori"
                                        id="nama_kategori"
                                        value="{{ old('nama_kategori') }}"
                                        maxlength="255"
                                        required
                                    >
                                    @error('nama_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok Kategori</label>
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

                                <button class="btn btn-primary" type="submit">Simpan</button>
                                <a class="btn btn-warning" href="{{ route('kategori.index') }}">Kembali ke Halaman Kategori</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection