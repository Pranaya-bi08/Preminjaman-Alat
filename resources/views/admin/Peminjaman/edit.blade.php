@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
              <li class="breadcrumb-item active">Edit</li>
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
                <h3>Edit Data Peminjaman</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_user" class="form-label">Peminjam</label>
                        <select class="form-control" name="id_user" id="id_user">
                            <option value="">-- Pilih Peminjam --</option>
                            @foreach ($peminjams as $u)
                                <option value="{{ $u->id }}" {{ old('id_user', $peminjaman->id_user) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_alat" class="form-label">Alat</label>
                        <select class="form-control" name="id_alat" id="id_alat">
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($alat as $a)
                                <option value="{{ $a->id }}" {{ old('id_alat', $peminjaman->id_alat) == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_alat }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_alat')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah"
                            value="{{ old('jumlah', $peminjaman->jumlah) }}" min="1" />
                        @error('jumlah')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan"
                            value="{{ old('tanggal_pengajuan', $peminjaman->tanggal_pengajuan) }}" />
                        @error('tanggal_pengajuan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali"
                            value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" />
                        @error('tanggal_kembali')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <textarea class="form-control" name="keperluan" id="keperluan" rows="3">{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                        @error('keperluan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="menunggu" {{ old('status', $peminjaman->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="disetujui" {{ old('status', $peminjaman->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ old('status', $peminjaman->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" rows="3">{{ old('catatan', $peminjaman->catatan) }}</textarea>
                        @error('catatan')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-warning" href="{{ route('peminjaman.index') }}">Kembali ke Halaman Peminjaman</a>
                </form>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
