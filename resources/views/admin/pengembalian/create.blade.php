@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="font-medium mb-1">Tambah Pengembalian</h3>
                <p class="text-muted mb-0">Masukkan alat dan status pengembaliannya.</p>
            </div>
            <a href="{{ route('pengembalian.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Pengembalian</h4>

                @if ($alat->isEmpty())
                    <div class="alert alert-warning">Data alat belum tersedia. Tambahkan data alat terlebih dahulu.</div>
                @endif

                <form action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="id_alat">Alat</label>
                        <select name="id_alat" id="id_alat" class="form-control @error('id_alat') is-invalid @enderror" required>
                            <option value="">Pilih alat</option>
                            @foreach ($alat as $item)
                                <option value="{{ $item->id }}" @selected(old('id_alat') == $item->id)>
                                    {{ $item->nama_alat }} — {{ $item->kategori->nama_kategori ?? 'Tanpa kategori' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_alat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status Pengembalian</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="belum_dikembalikan" @selected(old('status', 'belum_dikembalikan') === 'belum_dikembalikan')>Belum Dikembalikan</option>
                            <option value="sudah_dikembalikan" @selected(old('status') === 'sudah_dikembalikan')>Sudah Dikembalikan</option>
                            <option value="terlambat" @selected(old('status') === 'terlambat')>Terlambat</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" @disabled($alat->isEmpty())>Simpan</button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
