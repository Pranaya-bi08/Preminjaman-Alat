@extends('layouts.master')

@section('content')
@php
    use App\Models\User;
    use App\Models\Alat;
    use App\Models\Kategori;
    use App\Models\Peminjaman;

    $totalPeminjam = User::where('role', 'peminjam')->count();
    $totalPetugas = User::where('role', 'petugas')->count();
    $totalAdmin = User::where('role', 'admin')->count();
    $totalAlat = Alat::count();
    $totalKategori = Kategori::count();
    $totalStok = Alat::sum('stok');
    $menunggu = Peminjaman::where('status', Peminjaman::STATUS_MENUNGGU)->count();
    $disetujui = Peminjaman::where('status', Peminjaman::STATUS_DISETUJUI)->count();
    $ditolak = Peminjaman::where('status', Peminjaman::STATUS_DITOLAK)->count();
    $riwayatTerbaru = Peminjaman::with(['peminjam', 'alat.kategori'])
        ->latest('tanggal_pengajuan')
        ->take(5)
        ->get();
    $alatKritis = Alat::with('kategori')->orderBy('stok', 'asc')->take(5)->get();
@endphp

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Peminjam</small>
                    <h3 class="mb-0 mt-1 font-weight-bold text-dark">{{ $totalPeminjam }}</h3>
                </div>
                <span class="btn btn-primary"><i class="mdi mdi-account-multiple"></i></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Petugas</small>
                    <h3 class="mb-0 mt-1 font-weight-bold text-dark">{{ $totalPetugas }}</h3>
                </div>
                <span class="btn btn-success"><i class="mdi mdi-account-check"></i></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Total Alat</small>
                    <h3 class="mb-0 mt-1 font-weight-bold text-dark">{{ $totalAlat }}</h3>
                </div>
                <span class="btn btn-warning text-white"><i class="mdi mdi-tools"></i></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted">Stok</small>
                    <h3 class="mb-0 mt-1 font-weight-bold text-dark">{{ $totalStok }}</h3>
                </div>
                <span class="btn btn-danger"><i class="mdi mdi-package-variant"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Menunggu</span>
                    <span class="badge badge-primary px-2 py-1">{{ $menunggu }}</span>
                </div>
                <div class="progress" style="height: 8px; background: #eef2f7;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $totalPeminjam > 0 ? ($menunggu / max($totalPeminjam,1)) * 100 : 0 }}%;" aria-valuenow="{{ $menunggu }}" aria-valuemin="0" aria-valuemax="{{ max($totalPeminjam,1) }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Disetujui</span>
                    <span class="badge badge-success px-2 py-1">{{ $disetujui }}</span>
                </div>
                <div class="progress" style="height: 8px; background: #eef2f7;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalPeminjam > 0 ? ($disetujui / max($totalPeminjam,1)) * 100 : 0 }}%;" aria-valuenow="{{ $disetujui }}" aria-valuemin="0" aria-valuemax="{{ max($totalPeminjam,1) }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Ditolak</span>
                    <span class="badge badge-danger px-2 py-1">{{ $ditolak }}</span>
                </div>
                <div class="progress" style="height: 8px; background: #eef2f7;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalPeminjam > 0 ? ($ditolak / max($totalPeminjam,1)) * 100 : 0 }}%;" aria-valuenow="{{ $ditolak }}" aria-valuemin="0" aria-valuemax="{{ max($totalPeminjam,1) }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Kategori</span>
                    <span class="badge badge-warning text-white px-2 py-1">{{ $totalKategori }}</span>
                </div>
                <div class="progress" style="height: 8px; background: #eef2f7;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalKategori > 0 ? ($totalKategori / max($totalKategori,1)) * 100 : 0 }}%;" aria-valuenow="{{ $totalKategori }}" aria-valuemin="0" aria-valuemax="{{ max($totalKategori,1) }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Riwayat Peminjaman</h5>
                    </div>
                    <a href="{{ route('petugas.persetujuan.index') }}" class="btn btn-sm btn-dark">Lihat semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th>Jumlah</th>
                                <th>Batas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatTerbaru as $item)
                                <tr>
                                    <td>{{ $item->peminjam->name ?? 'User' }}</td>
                                    <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->status === 'menunggu')
                                            <span class="badge badge-warning text-white">Menunggu</span>
                                        @elseif ($item->status === 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada data peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 font-weight-bold text-dark">Stok Rendah</h5>
                <ul class="list-unstyled mb-0">
                    @forelse ($alatKritis as $alat)
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="font-weight-bold text-dark">{{ $alat->nama_alat }}</div>
                                <small class="text-muted">{{ $alat->kategori->nama_kategori ?? 'Umum' }}</small>
                            </div>
                            <span class="badge badge-light text-dark border px-2 py-1">
                                {{ $alat->stok }}
                            </span>
                        </li>
                    @empty
                        <li class="text-muted text-center py-3">Semua alat masih aman.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="font-weight-bold text-dark mb-3">Ringkasan Sistem</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded">
                            <strong>Admin:</strong> {{ $totalAdmin }} akun
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded">
                            <strong>Aktif:</strong> {{ $totalPeminjam + $totalPetugas }} pengguna
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
