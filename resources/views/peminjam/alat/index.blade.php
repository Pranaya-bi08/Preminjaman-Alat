@extends('layouts.master')

@section('content')


{{-- ================= CLEAN PAGE HEADER ================= --}}
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('peminjam.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Katalog & Kategori Alat</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Katalog & Kategori Alat</h3>
            <p class="text-muted mb-0">
                Daftar seluruh alat inventaris yang tersedia berdasarkan kategori.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#modalPinjamAlat">
                <i class="mdi mdi-plus mr-1"></i> Ajukan Pinjam Alat
            </button>
        </div>
    </div>
</div>

{{-- ================= KATEGORI ALAT ================= --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold text-dark mb-0">Kategori Alat</h5>
        @if(request('kategori') || request('search'))
            <a href="{{ route('peminjam.alat.index') }}" class="font-weight-bold">
                <i class="mdi mdi-close"></i> Hapus Filter
            </a>
        @endif
    </div>

    <div class="row">
        {{-- Semua Kategori --}}
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('peminjam.alat.index') }}" class="card card-body {{ !request('kategori') ? 'border-primary' : '' }}">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="font-weight-bold text-dark font-weight-bold font-15">Semua Kategori</div>
                        <small class="text-muted">{{ $kategoris->sum('alat_count') }} total alat</small>
                    </div>
                    <span class="badge badge-secondary">{{ $kategoris->sum('alat_count') }}</span>
                </div>
            </a>
        </div>

        {{-- Tiap Kategori --}}
        @foreach ($kategoris as $kat)
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="{{ route('peminjam.alat.index', ['kategori' => $kat->id]) }}" class="card card-body {{ request('kategori') == $kat->id ? 'border-primary' : '' }}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="font-weight-bold text-dark font-weight-bold font-15">{{ $kat->nama_kategori }}</div>
                            <small class="text-muted">{{ $kat->alat_count }} unit terdaftar</small>
                        </div>
                        <span class="badge badge-secondary">{{ $kat->alat_count }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

{{-- ================= DAFTAR ALAT DENGAN FILTER ================= --}}
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">
                @if ($selectedKategori)
                    Katalog Kategori: {{ $selectedKategori->nama_kategori }}
                @else
                    Daftar Semua Alat
                @endif
            </h5>
            <small class="text-muted">Menampilkan <strong>{{ $alatList->count() }}</strong> alat</small>
        </div>

        {{-- Form Pencarian --}}
        <div class="mt-2 mt-md-0">
            <form action="{{ route('peminjam.alat.index') }}" method="GET" class="d-flex align-items-center">
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama alat..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-4">
        @if ($alatList->count() > 0)
            <div class="row">
                @foreach ($alatList as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card card-body h-100">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="font-weight-bold text-dark mb-1">{{ $item->nama_alat }}</h5>
                                    <small class="text-muted">Kode: #ALT-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                                <span class="badge badge-secondary">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                                <span class="text-muted">Stok Tersedia:</span>
                                <span class="font-weight-bold {{ $item->stok > 0 ? 'text-dark' : 'text-danger' }}">
                                    {{ $item->stok }} Unit
                                </span>
                            </div>

                            <div class="mt-auto pt-2">
                                @if ($item->stok > 0)
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-block font-weight-bold btn-pinjam-cepat"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_alat }}"
                                            data-stok="{{ $item->stok }}"
                                           >
                                        Ajukan Peminjaman
                                    </button>
                                @else
                                    <button type="button" class="btn btn-light btn-block text-muted" disabled>
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="mdi mdi-magnify font-30 d-block mb-2"></i>
                <h5 class="font-weight-bold text-dark">Tidak Ada Alat Ditemukan</h5>
                <p class="text-muted mb-3">
                    Tidak ada data alat yang sesuai dengan pencarian atau kategori ini.
                </p>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
                    Lihat Semua Alat
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ================= CLEAN MODAL PINJAM ALAT ================= --}}
<div class="modal fade" id="modalPinjamAlat" tabindex="-1" role="dialog" aria-labelledby="modalPinjamAlatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <div>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalPinjamAlatLabel">Form Pengajuan Peminjaman Alat</h5>
                    <small class="text-muted">Lengkapi data untuk mengajukan pinjaman alat</small>
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
                                <option value="{{ $alat->id }}" data-stok="{{ $alat->stok }}" data-kategori="{{ $alat->kategori->nama_kategori ?? '-' }}" @selected(old('id_alat') == $alat->id)>
                                    {{ $alat->nama_alat }} (Kategori: {{ $alat->kategori->nama_kategori ?? 'Umum' }} — Sisa: {{ $alat->stok }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted" id="stokInfoBadge">Pilih alat untuk memeriksa stok.</small>
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
                                Tanggal Pengambilan <span class="text-danger">*</span>
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
                        <textarea name="keperluan" id="modal_keperluan" rows="3" class="form-control" placeholder="Contoh: Praktikum, dokumentasi kegiatan, tugas kelompok...">{{ old('keperluan') }}</textarea>
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
        // Handle Tombol "Pinjam" langsung dari card alat
        $(document).on('click', '.btn-pinjam-cepat', function () {
            var alatId = $(this).data('id');
            $('#modal_id_alat').val(alatId).trigger('change');
            $('#modalPinjamAlat').modal('show');
        });

        // Update info stok saat memilih alat di modal
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
