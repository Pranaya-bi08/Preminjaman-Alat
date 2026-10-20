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
                @if (session('success'))
                  <div class="alert alert-success">
                      {{session('success')}}
                  </div>
                  @endif
                <h3>Tabel Alat
                    <a class="btn btn-primary" href="{{ route('alat.create') }}">
                      <i class= "fas fa-plus"></i>Tambah Data Alat</a>
                </h3>
              </div>
              <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Alat</th>
                                <th>Stok</th>
                                <th>Ketersediaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alat as $a)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $a -> nama_alat }}</td>
                            <td>{{ $a -> stok }}</td>
                            <td>
                                @if ($a->stok > 0)
                                    <span class="badge badge-success">Tersedia</span>
                                @else
                                    <span class="badge badge-danger">Tidak tersedia</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-warning" href="{{route ('alat.edit', $a->id)}}">
                                  <i class= "fas fa-edit"></i>Edit</a>
                                <a class="btn btn-danger" 
                                onclick="return confirm('Yakin Mau Hapus Data Ini?')"  
                                href="{{route ('alat.destroy', $a->id)}}">
                                <i class= "fas fa-trash"></i>Hapus</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
