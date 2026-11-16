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

{{-- ================= CLEAN PAGE HEADER ================= --}}
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('peminjam.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengembalian Alat</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Pengembalian Alat</h3>
            <p class="text-muted mb-0">
                Pantau alat yang sedang dipinjam dan lakukan proses pengembalian alat secara mandiri.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary font-weight-bold">
                <i class="mdi mdi-tools mr-1"></i> Pinjam Alat Baru
            </a>
        </div>
    </div>
</div>

{{-- ================= TABEL ALAT YANG SEDANG DIPINJAM (AKTIF) ================= --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Alat yang Sedang Dipinjam (Wajib Dikembalikan)</h5>
            <p class="text-muted mb-0">
                Pastikan kondisi alat dalam keadaan lengkap dan baik sebelum dikembalikan.
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-secondary font-13">
                {{ $pinjamanAktif->count() }} Alat Belum Dikembalikan
            </span>
        </div>
    </div>

    <div class="card-body p-4">
        @if ($pinjamanAktif->count() > 0)
            <div class="table-responsive border rounded">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Alat yang Dipinjam</th>
                            <th>Kategori</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th class="text-center">Status Tenggat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjamanAktif as $pinjam)
                            @php
                                $tglKembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali)->startOfDay();
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $isOverdue = $today->gt($tglKembali);
                                $diffDays = $today->diffInDays($tglKembali, false);
                            @endphp
                            <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                                <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $pinjam->alat->nama_alat ?? 'Alat #'.$pinjam->id_alat }}</div>
                                    @if ($pinjam->keperluan)
                                        <small class="text-muted">Keperluan: {{ $pinjam->keperluan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $pinjam->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                                </td>
                                <td class="text-center font-weight-bold">{{ $pinjam->jumlah }} Unit</td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>
                                <td class="font-weight-bold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    @if ($isOverdue)
                                        <span class="badge badge-danger">
                                            Terlambat {{ abs($diffDays) }} Hari
                                        </span>
                                    @elseif ($diffDays === 0)
                                        <span class="badge badge-warning text-dark">
                                            Batas Hari Ini
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Sisa {{ $diffDays }} Hari
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('peminjam.kembalikan', $pinjam->id) }}" method="POST" class="form-kembalikan-alat">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success px-3 font-weight-bold btn-kembalikan"
                                                data-nama="{{ $pinjam->alat->nama_alat ?? 'Alat' }}"
                                                data-jumlah="{{ $pinjam->jumlah }}"
                                               >
                                            Kembalikan Alat
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="mdi mdi-check-circle-outline font-30 text-success d-block mb-2"></i>
                <h5 class="font-weight-bold text-dark">Tidak Ada Pinjaman Aktif</h5>
                <p class="text-muted mb-3">
                    Semua alat yang Anda pinjam telah dikembalikan dengan lengkap, atau Anda belum memiliki peminjaman aktif.
                </p>
                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-outline-primary btn-sm font-weight-bold">
                    Cari Alat di Katalog
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ================= TABEL RIWAYAT PENGEMBALIAN ================= --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Riwayat Pengembalian Selesai</h5>
            <small class="text-muted">Total <strong>{{ $riwayatPengembalian->count() }}</strong> riwayat pengembalian alat yang telah tuntas</small>
        </div>
    </div>

    <div class="card-body p-4">
        @if ($riwayatPengembalian->count() > 0)
            <div class="table-responsive border rounded">
                <table class="table table-hover mb-0" id="tableRiwayatKembali">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Alat</th>
                            <th>Kategori</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Catatan Pengembalian</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatPengembalian as $item)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold text-dark">
                                    {{ $item->alat->nama_alat ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $item->alat->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td class="text-center font-weight-bold">{{ $item->jumlah }} Unit</td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->catatan ?: '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        Sudah Dikembalikan
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <small>Belum ada riwayat pengembalian selesai.</small>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#tableRiwayatKembali')) {
            $('#tableRiwayatKembali').DataTable().destroy();
        }
        $('#tableRiwayatKembali').DataTable({
            "order": [[0, "asc"]],
            "language": {
                "search": "Cari Riwayat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada riwayat"
            }
        });

        $('.form-kembalikan-alat').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var btn = $(this).find('.btn-kembalikan');
            var namaAlat = btn.data('nama');
            var jumlah = btn.data('jumlah');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Kembalikan Alat?',
                    text: "Konfirmasi pengembalian " + jumlah + " unit " + namaAlat + ".",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Kembalikan',
                    cancelButtonText: 'Batal'
                    }).then(function (result) {
                        console.log(result);
                        if (result.isConfirmed || result.value === true) {
                            HTMLFormElement.prototype.submit.call(form);
                        }
                    });
            } else {
                if (confirm("Apakah Anda yakin ingin mengembalikan " + jumlah + " unit " + namaAlat + "?")) {
                    form.submit();
                }
            }
        });
    });
</script>
@endpush
