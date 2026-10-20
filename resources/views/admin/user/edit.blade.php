@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="row">
          <div class="col-lg-12">
             <div class="card">
              <div class="card-header">
                <h3>Sample Table
                    <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah Data User</a>
                </h3>
              </div>
              <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id=""
                            aria-describedby="helpId" placeholder="" value="{{ $user->name }}" />
                    </div>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id=""
                            aria-describedby="helpId" placeholder="" value="{{ $user->email }}" />
                    </div>
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a class="btn btn-warning" href="{{ route('user.index') }}">Kembali ke Halaman User</a>
                </form>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
