@extends('layouts.master')

@section('content')



@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-check-circle mr-2 font-18 text-success"></i>
            <div>
                <strong>Berhasil:</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-alert-circle mr-2 font-18 text-danger"></i>
            <div>
                <strong>Perhatian:</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('peminjam.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Pinjam</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Pengajuan Peminjaman Alat</h3>
            <p class="text-muted mb-0">
                Kelola seluruh permohonan peminjaman alat inventaris dan pantau status persetujuan dari petugas.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#modalPinjamAlat">
                <i class="mdi mdi-plus mr-1"></i> Ajukan Peminjaman Baru
            </button>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Daftar Pengajuan Peminjaman</h5>
            <small class="text-muted">Total <strong>{{ $pengajuanList->count() }}</strong> permohonan ditampilkan</small>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
                <i class="mdi mdi-tools mr-1"></i> Cek Stok di Katalog
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        {{-- Filter Status Tabs --}}
        <div class="mb-3">
            <a href="{{ route('peminjam.pengajuan.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua Status <span class="badge badge-light">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'menunggu']) }}" class="btn btn-sm {{ request('status') === 'menunggu' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Menunggu <span class="badge badge-light">{{ $counts['menunggu'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'disetujui']) }}" class="btn btn-sm {{ request('status') === 'disetujui' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Disetujui <span class="badge badge-light">{{ $counts['disetujui'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'dikembalikan']) }}" class="btn btn-sm {{ request('status') === 'dikembalikan' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Dikembalikan <span class="badge badge-light">{{ $counts['dikembalikan'] }}</span>
            </a>
            <a href="{{ route('peminjam.pengajuan.index', ['status' => 'ditolak']) }}" class="btn btn-sm {{ request('status') === 'ditolak' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Ditolak <span class="badge badge-light">{{ $counts['ditolak'] }}</span>
            </a>
        </div>

        <div class="table-responsive border rounded">
            <table class="table table-hover mb-0" id="tablePengajuanFull">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Alat yang Diajukan</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Batas Kembali</th>
                        <th>Keperluan</th>
                        <th class="text-center">Status</th>
                        <th>Catatan Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuanList as $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? 'Alat #' . $item->id_alat }}</div>
                                <small class="text-muted">ID: #PGJ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $item->alat->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                            <td class="text-muted">
                                {{ $item->tanggal_pengambilan ? \Carbon\Carbon::parse($item->tanggal_pengambilan)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="font-weight-bold">
                                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="text-muted">
                                {{ $item->keperluan ?: '-' }}
                            </td>
                            <td class="text-center">
                                @if ($item->isSudahDikembalikan())
                                    <span class="badge badge-success">Dikembalikan</span>
                                @elseif ($item->status === 'menunggu')
                                    <span class="badge badge-warning text-dark">Menunggu</span>
                                @elseif ($item->status === 'disetujui')
                                    <span class="badge badge-primary">Disetujui</span>
                                @elseif ($item->status === 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->catatan)
                                    <small class="text-muted font-italic">{{ $item->catatan }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="mdi mdi-clipboard-text-outline font-30 d-block mb-2"></i>
                                <div class="font-weight-bold text-dark">Belum Ada Pengajuan</div>
                                <small class="text-muted">Klik tombol "Ajukan Peminjaman Baru" untuk memulai permohonan pinjam alat.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPinjamAlat" tabindex="-1" role="dialog" aria-labelledby="modalPinjamAlatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <div>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalPinjamAlatLabel">Form Pengajuan Peminjaman Alat</h5>
                    <small class="text-muted">Isi formulir untuk mengajukan peminjaman alat inventaris</small>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('peminjam.pengajuan.store') }}" method="POST" id="formPinjamAlat">
                @csrf
                <div class="modal-body p-4">
                    {{-- Pilihan Alat --}}
                    <div class="form-group mb-3">
                        <label for="modal_id_alat" class="font-weight-bold text-dark">
                            Pilih Alat <span class="text-danger">*</span>
                        </label>
                        <select name="id_alat" id="modal_id_alat" class="form-control" required>
                            <option value="">-- Pilih Alat yang Tersedia --</option>
                            @foreach ($semuaAlatTersedia as $alat)
                                <option value="{{ $alat->id }}" data-stok="{{ $alat->stok }}" @selected(old('id_alat') == $alat->id)>
                                    {{ $alat->nama_alat }} (Kategori: {{ $alat->kategori->nama_kategori ?? 'Umum' }} — Sisa: {{ $alat->stok }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted" id="stokInfoBadge">Pilih alat untuk memeriksa ketersediaan.</small>
                    </div>

                    {{-- Jumlah & Tanggal Pengambilan --}}
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="modal_jumlah" class="font-weight-bold text-dark">
                                Jumlah Unit <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="jumlah" id="modal_jumlah" class="form-control" min="1" max="100" value="{{ old('jumlah', 1) }}" required>
                            <small class="text-muted" id="maxStokText">Minimal 1 unit</small>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="modal_tanggal_pengambilan" class="font-weight-bold text-dark">
                                Tanggal Pengambilan<span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_pengambilan" id="modal_tanggal_pengambilan" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('tanggal_pengambilan', date('Y-m-d')) }}" required>
                            <small class="text-muted">Pilih tanggal pengambilan alat</small>
                        </div>
                    </div>

                    {{-- Keperluan --}}
                    <div class="form-group mb-0">
                        <label for="modal_keperluan" class="font-weight-bold text-dark">
                            Keperluan Peminjaman
                        </label>
                        <textarea name="keperluan" id="modal_keperluan" rows="3" class="form-control" placeholder="Contoh: Praktikum, dokumentasi kegiatan, tugas...">{{ old('keperluan') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#tablePengajuanFull')) {
            $('#tablePengajuanFull').DataTable().destroy();
        }
        $('#tablePengajuanFull').DataTable({
            "order": [[0, "asc"]],
            "language": {
                "search": "Cari Pengajuan:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ pengajuan",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data pengajuan"
            }
        });

        $('#modal_id_alat').on('change', function () {
            var selected = $(this).find(':selected');
            var stok = selected.data('stok');
            if (stok !== undefined && stok !== '') {
                $('#stokInfoBadge').html('<span class="text-success font-weight-bold">Tersedia: ' + stok + ' unit</span>');
                $('#modal_jumlah').attr('max', stok);
                $('#maxStokText').text('Maksimal: ' + stok + ' unit');
                if (parseInt($('#modal_jumlah').val()) > parseInt(stok)) {
                    $('#modal_jumlah').val(stok);
                }
            } else {
                $('#stokInfoBadge').text('Pilih alat untuk memeriksa ketersediaan.');
                $('#maxStokText').text('Minimal 1 unit');
                $('#modal_jumlah').removeAttr('max');
            }
        });
    });
</script>
@endpush
