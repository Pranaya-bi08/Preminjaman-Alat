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
                <h3>Tabel User
                    <a class="btn btn-primary" href="{{ route('user.create') }}">
                      <i class= "fas fa-plus"></i>Tambah Data User</a>
                </h3>
              </div>
              <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u -> name }}</td>
                            <td>{{ $u -> email }}</td>
                            <td>{{ $u -> role }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{route ('user.edit', $u->id)}}">
                                  <i class= "fas fa-edit"></i>Edit</a>
                                <a class="btn btn-danger" 
                                onclick="return confirm('Yakin Mau Hapus Data Ini?')"  
                                href="{{route ('user.destroy', $u->id)}}">
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
