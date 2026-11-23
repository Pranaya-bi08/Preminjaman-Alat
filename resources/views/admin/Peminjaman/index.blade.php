@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Peminjaman Alat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Peminjaman</li>
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
                @if (session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger">
                      {{ session('error') }}
                  </div>
                @endif
                <h3>Tabel Peminjaman</h3>
              </div>
              <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->peminjam->name }}</td>
                                <td>{{ $p->alat->nama_alat }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>{{ $p->tanggal_pengajuan }}</td>
                                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                                <td>
                                    @if ($p->status == 'menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif ($p->status == 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif ($p->status == 'ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('peminjaman.edit', $p->id) }}">
                                      <i class="fas fa-edit"></i>Edit</a>
                                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin Mau Hapus Data Ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>Hapus
                                        </button>
                                    </form>
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
