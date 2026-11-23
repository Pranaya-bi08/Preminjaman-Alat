@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Peminjaman</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Laporan Peminjaman</li>
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
                <h3 class="card-title">Laporan Peminjaman Alat</h3>
              </div>
              <div class="card-body">

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('peminjaman.laporan') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Dari Tanggal</label>
                            <input type="date" class="form-control" name="dari" value="{{ request('dari') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Sampai Tanggal</label>
                            <input type="date" class="form-control" name="sampai" value="{{ request('sampai') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">-- Semua --</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('peminjaman.laporan') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->peminjam->name ?? '-' }}</td>
                                    <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('j M Y') }}</td>
                                    <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('j M Y') : '-' }}</td>
                                    <td>
                                        @switch($item->status)
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
                                    </td>
                                    <td>{{ $item->petugas->name ?? '-' }}</td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Tidak ada data peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

              </div>
             </div>
          </div>
        </section>
        </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('table').DataTable({
            "order": [],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" }
            }
        });
    });
</script>
@endpush
