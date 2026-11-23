@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="row">
          <div class="col-lg-12">
             <div class="card">
              <div class="card-header">
                <h3>Tambah Data Peminjaman</h3>
              </div>
              <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_alat" class="form-label">Alat</label>
                        <select class="form-control" name="id_alat" id="id_alat">
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($alat as $a)
                                <option value="{{ $a->id }}" {{ old('id_alat') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_alat }} (Stok: {{ $a->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_alat')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah"
                            value="{{ old('jumlah', 1) }}" min="1" />
                        @error('jumlah')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali"
                            value="{{ old('tanggal_kembali') }}" min="{{ date('Y-m-d') }}" />
                        @error('tanggal_kembali')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <textarea class="form-control" name="keperluan" id="keperluan" rows="3">{{ old('keperluan') }}</textarea>
                        @error('keperluan')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-secondary" href="{{ route('peminjaman.index') }}">Kembali</a>
                </form>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
