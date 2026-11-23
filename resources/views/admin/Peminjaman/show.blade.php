@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
        <div class="row">
          <div class="col-lg-12">
             <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Detail Peminjaman #{{ $peminjaman->id }}</h3>
                <div>
                    <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:200px">Peminjam</th>
                        <td>{{ $peminjaman->peminjam->name ?? '-' }} ({{ $peminjaman->peminjam->email ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Alat</th>
                        <td>{{ $peminjaman->alat->nama_alat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $peminjaman->alat->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>{{ $peminjaman->jumlah }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->translatedFormat('j F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengambilan</th>
                        <td>{{ $peminjaman->tanggal_pengambilan ? \Carbon\Carbon::parse($peminjaman->tanggal_pengambilan)->translatedFormat('j F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('j F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @switch($peminjaman->status)
                                @case('menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                    @break
                                @case('disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                    @break
                            @endswitch
                            @if($peminjaman->isSudahDikembalikan())
                                <span class="badge badge-info ml-1">Sudah Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>{{ $peminjaman->keperluan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $peminjaman->catatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Disetujui oleh</th>
                        <td>{{ $peminjaman->petugas->name ?? '-' }}</td>
                    </tr>
                </table>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
