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
                    <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Menyetujui Peminjaman</li>
                </ol>
            </nav>
            <h3 class="font-weight-bold mb-1 text-dark">Menyetujui & Menolak Peminjaman</h3>
            <p class="text-muted mb-0">
                Tinjau permohonan pinjam alat dari peminjam, setujui untuk memotong stok alat atau tolak dengan alasan resmi.
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="mdi mdi-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-light border">
                <i class="mdi mdi-eye mr-1"></i> Pantau Pengembalian
            </a>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">Daftar Permohonan Peminjaman</h5>
            <small class="text-muted">Total <strong>{{ $peminjamanList->count() }}</strong> permohonan dalam daftar</small>
        </div>
        <div class="mt-2 mt-md-0">
            <form action="{{ route('petugas.persetujuan.index') }}" method="GET" class="d-flex align-items-center">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="input-group">
                    <div class="input-group-append">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-4">

        <div class="mb-3">
            <a href="{{ route('petugas.persetujuan.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua Permohonan <span class="badge badge-light">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'menunggu']) }}" class="btn btn-sm {{ request('status') === 'menunggu' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Menunggu Verifikasi <span class="badge badge-light">{{ $counts['menunggu'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'disetujui']) }}" class="btn btn-sm {{ request('status') === 'disetujui' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Disetujui <span class="badge badge-light">{{ $counts['disetujui'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'dikembalikan']) }}" class="btn btn-sm {{ request('status') === 'dikembalikan' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Dikembalikan <span class="badge badge-light">{{ $counts['dikembalikan'] }}</span>
            </a>
            <a href="{{ route('petugas.persetujuan.index', ['status' => 'ditolak']) }}" class="btn btn-sm {{ request('status') === 'ditolak' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Ditolak <span class="badge badge-light">{{ $counts['ditolak'] }}</span>
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive border rounded">
            <table class="table table-hover mb-0" id="tablePersetujuan">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th class="text-center">Jml (Sisa Stok)</th>
                        <th>Tgl Pengajuan</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Batas Kembali</th>
                        <th>Keperluan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanList as $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->peminjam->name ?? 'User #'.$item->id_user }}</div>
                                <small class="text-muted">{{ $item->peminjam->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $item->alat->nama_alat ?? 'Alat #' . $item->id_alat }}</div>
                                <span class="badge badge-secondary">{{ $item->alat->kategori->nama_kategori ?? 'Umum' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="font-weight-bold font-15">{{ $item->jumlah }} Unit</span>
                                <small class="d-block text-muted">(Sisa: {{ $item->alat->stok ?? 0 }})</small>
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                            </td>
                            <td class="text-muted">
                                {{ $item->tanggal_pengambilan ? \Carbon\Carbon::parse($item->tanggal_pengambilan)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="font-weight-bold text-dark">
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

                                @if ($item->catatan)
                                    <small class="d-block text-muted font-italic mt-1">
                                        Catatan: {{ Str::limit($item->catatan, 35) }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status === 'menunggu')
                                    <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST" class="d-inline form-setujui-row" data-tanggal="{{ $item->tanggal_kembali ?? '' }}"
                                        data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                        data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}">
                                        @csrf
                                        <input type="hidden" name="tanggal_kembali" value="">
                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1 font-weight-bold" title="Setujui Peminjaman">
                                            <i class="mdi mdi-check mr-1"></i> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 font-weight-bold btn-tolak-row"
                                            data-id="{{ $item->id }}"
                                            data-peminjam="{{ $item->peminjam->name ?? 'Peminjam' }}"
                                            data-alat="{{ $item->alat->nama_alat ?? 'Alat' }}"
                                            title="Tolak Peminjaman">
                                        <i class="mdi mdi-close mr-1"></i> Tolak
                                    </button>
                                @else
                                    <span class="text-muted">
                                        <i class="mdi mdi-check-all mr-1"></i> Selesai Diproses
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="mdi mdi-clipboard-text-outline font-30 d-block mb-2"></i>
                                <div class="font-weight-bold text-dark">Tidak Ada Data Permohonan</div>
                                <small class="text-muted">Tidak ditemukan data yang sesuai dengan status filter saat ini.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Penolakan --}}
<div class="modal fade" id="modalTolakPengajuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white">
                <h5 class="modal-title font-weight-bold text-dark">Tolak Permohonan Peminjaman</h5>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="formTolakModal">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3" id="textKonfirmasiTolakModal">
                        Masukkan alasan penolakan agar peminjam dapat mengetahui penyebab permohonan tidak disetujui.
                    </p>
                    <div class="form-group mb-0">
                        <label for="catatan_tolak_field" class="font-weight-bold text-dark">
                            Alasan / Catatan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea name="catatan" id="catatan_tolak_field" rows="3" class="form-control" placeholder="Contoh: Alat sedang dalam perawatan, alat telah dipesan oleh kelas lain..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4">
                        Tolak Pengajuan
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
        if ($.fn.DataTable.isDataTable('#tablePersetujuan')) {
            $('#tablePersetujuan').DataTable().destroy();
        }
        $('#tablePersetujuan').DataTable({
            "order": [],
            "language": {
                "search": "Cari Cepat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": { "previous": "Sebelumnya", "next": "Selanjutnya" },
                "emptyTable": "Belum ada data peminjaman"
            }
        });

        // Konfirmasi Setujui
        $(document).on('submit', '.form-setujui-row', function (e) {
            e.preventDefault();
            var form = this;
            var now = new Date();
            var hariIni = now.getFullYear() + '-' +
                String(now.getMonth() + 1).padStart(2, '0') + '-' +
                String(now.getDate()).padStart(2, '0');
            var tanggalDefault = String($(form).data('tanggal') || '').trim();
            if (!tanggalDefault) {
                tanggalDefault = hariIni;
            }

            var maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 5);
            var maxTanggal = maxDate.getFullYear() + '-' +
                String(maxDate.getMonth() + 1).padStart(2, '0') + '-' +
                String(maxDate.getDate()).padStart(2, '0');

            if (tanggalDefault > maxTanggal) {
                tanggalDefault = maxTanggal;
            }

            var kirimForm = function () {
                HTMLFormElement.prototype.submit.call(form);
            };

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Setujui Peminjaman?',
                    html: '<div class="text-left">' +
                        '<p class="mb-3 text-muted">Peminjam: <strong>' + $(form).data('peminjam') + '</strong><br>Alat: <strong>' + $(form).data('alat') + '</strong></p>' +
                        '<label for="swal-tgl" class="d-block mb-2 font-weight-bold text-dark">Batas pengembalian</label>' +
                        '<input type="date" id="swal-tgl" class="form-control" value="' + tanggalDefault + '" min="' + hariIni + '" max="' + maxTanggal + '" required>' +
                        '</div>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal',
                    preConfirm: function () {
                        var tgl = String($('#swal-tgl').val() || '').trim();
                        if (!tgl) {
                            Swal.showValidationMessage('Batas pengembalian wajib diisi.');
                            return false;
                        }
                        if (tgl < hariIni) {
                            Swal.showValidationMessage('Tanggal tidak boleh sebelum hari ini.');
                            return false;
                        }
                        if (tgl > maxTanggal) {
                            Swal.showValidationMessage('Batas pengembalian maksimal 5 hari sejak hari ini.');
                            return false;
                        }
                        return tgl;
                    }
                }).then(function (res) {
                    var submittedValue = res && (res.value !== undefined && res.value !== null && res.value !== false && res.value !== '') ? res.value : null;
                    var isConfirmed = res && (res.isConfirmed === true || res.value === true || submittedValue !== null);

                    if (isConfirmed && submittedValue) {
                        $(form).find('input[name="tanggal_kembali"]').val(String(submittedValue).trim());
                        kirimForm();
                    }
                });
            } else {
                $(form).find('input[name="tanggal_kembali"]').val(tanggalDefault);
                if (confirm('Setujui peminjaman ini? Stok alat akan berkurang.')) {
                    kirimForm();
                }
            }
        });

        // Buka modal tolak
        $(document).on('click', '.btn-tolak-row', function () {
            var id = $(this).data('id');
            var peminjam = $(this).data('peminjam');
            var alat = $(this).data('alat');

            $('#textKonfirmasiTolakModal').text('Anda akan menolak pengajuan alat "' + alat + '" dari ' + peminjam + '.');
            $('#formTolakModal').attr('action', '/petugas/persetujuan/' + id + '/tolak');
            $('#modalTolakPengajuan').modal('show');
        });
    });
</script>
@endpush
