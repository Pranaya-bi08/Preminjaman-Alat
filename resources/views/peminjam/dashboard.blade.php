@extends('layouts.master')

@section('content')


{{-- ================= ALERT NOTIFIKASI ================= --}}
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

{{-- ================= HEADER ================= --}}
<div class="mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-1">
                <span class="badge badge-secondary mr-2">Peminjam</span>
                <span class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-1">Selamat Datang, {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-3">
                Dashboard utama untuk memantau status peminjaman alat, memeriksa batas pengembalian, dan mengakses menu layanan peminjaman.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary font-weight-bold px-3 py-2 mr-2 mb-2" data-toggle="modal" data-target="#modalPinjamAlat">
                    <i class="mdi mdi-plus mr-1"></i> Ajukan Peminjaman
                </button>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2 mr-2 mb-2">
                    <i class="mdi mdi-format-list-bulleted mr-1"></i> Daftar & Kategori Alat
                </a>
                <a href="{{ route('peminjam.pengembalian.index') }}" class="btn btn-light border px-3 py-2 mb-2">
                    <i class="mdi mdi-backup-restore mr-1"></i> Pengembalian Alat
                </a>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-right">
            <div class="p-3 bg-light rounded border text-left d-inline-block">
                <span class="text-muted text-uppercase">Ringkasan Status</span>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span>Peminjaman Aktif</span>
                    <span class="badge badge-success">{{ $stats['dipinjam_aktif'] }} Unit</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span>Menunggu Konfirmasi</span>
                    <span class="badge badge-warning text-dark">{{ $stats['menunggu'] }} Pengajuan</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="row">
    <!-- Total Alat Tersedia -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Alat Tersedia</span>
                    <div class="h3 font-weight-bold">{{ $stats['total_alat_tersedia'] }}</div>
                    <div class="text-muted small">dari {{ $stats['total_kategori'] }} kategori alat</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-tools"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('peminjam.alat.index') }}" class="font-weight-bold">
                    Buka Halaman Katalog &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Menunggu Persetujuan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Menunggu Persetujuan</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['menunggu'] }}</div>
                    <div class="text-muted small">permohonan menunggu petugas</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-clock-outline"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('peminjam.pengajuan.index') }}" class="font-weight-bold">
                    Halaman Pengajuan &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Sedang Dipinjam</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['dipinjam_aktif'] }}</div>
                    <div class="text-muted small">alat aktif wajib dikembalikan</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-package-variant"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('peminjam.pengembalian.index') }}" class="font-weight-bold">
                    Halaman Pengembalian &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Selesai Dikembalikan -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card card-body h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted small">Sudah Dikembalikan</span>
                    <div class="h3 font-weight-bold text-dark">{{ $stats['sudah_kembali'] }}</div>
                    <div class="text-muted small">total riwayat peminjaman</div>
                </div>
                <div class="bg-light rounded p-2">
                    <i class="mdi mdi-check-all"></i>
                </div>
            </div>
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('peminjam.pengembalian.index') }}" class="text-muted">
                    Lihat Riwayat &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ================= MENU NAVIGASI TERPISAH (SHORTCUT CARDS) ================= --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.alat.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-view-list font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Daftar & Kategori Alat</h5>
                        <small class="text-muted">{{ $stats['total_alat_tersedia'] }} alat inventaris</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Jelajahi seluruh alat yang tersedia berdasarkan kategori dan periksa rincian stok unit.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top text-primary font-weight-bold">
                Buka Halaman Alat &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.pengajuan.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-send font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Pengajuan Pinjam</h5>
                        <small class="text-muted">{{ $stats['total_pengajuan'] }} riwayat pengajuan</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Buat pengajuan baru dan pantau status persetujuan dari petugas secara terpisah.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold">
                Buka Halaman Pengajuan &rarr;
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">
        <a href="{{ route('peminjam.pengembalian.index') }}" class="card card-body h-100 text-decoration-none">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded p-2 mr-3">
                        <i class="mdi mdi-backup-restore font-22"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Pengembalian Alat</h5>
                        <small class="text-muted">{{ $stats['dipinjam_aktif'] }} pinjaman aktif</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    Periksa batas waktu pengembalian dan lakukan proses pengembalian alat secara mandiri.
                </p>
            </div>
            <div class="mt-3 pt-2 border-top font-weight-bold">
                Buka Halaman Pengembalian &rarr;
            </div>
        </a>
    </div>
</div>

{{-- ================= RINGKASAN AKTIVITAS TERBARU ================= --}}
<div class="row">
    <!-- Preview Alat Tersedia -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0">Alat Tersedia (Pratinjau)</h6>
                <a href="{{ route('peminjam.alat.index') }}" class="font-weight-bold">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alatTersediaPreview as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $item->nama_alat }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td class="text-center font-weight-bold">{{ $item->stok }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary px-2 py-1 font-weight-bold btn-pinjam-cepat"
                                                data-id="{{ $item->id }}"
                                               >
                                            Pinjam
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada alat tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Pengajuan Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0">Pengajuan Terbaru</h6>
                <a href="{{ route('peminjam.pengajuan.index') }}" class="font-weight-bold">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Alat</th>
                                <th class="text-center">Jumlah</th>
                                <th>Tgl Pengambilan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuanTerbaru as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $item->alat->nama_alat ?? '-' }}</td>
                                    <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>
                                    <td class="text-muted">
                                        {{ $item->tanggal_pengambilan ? \Carbon\Carbon::parse($item->tanggal_pengambilan)->format('d-m-Y') : '-' }}
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL FORM PINJAM ALAT ================= --}}
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
        $(document).on('click', '.btn-pinjam-cepat', function () {
            var alatId = $(this).data('id');
            $('#modal_id_alat').val(alatId).trigger('change');
            $('#modalPinjamAlat').modal('show');
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
