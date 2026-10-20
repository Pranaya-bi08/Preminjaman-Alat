@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="font-medium mb-1">Edit Pengembalian</h3>
                <p class="text-muted mb-0">Perbarui data alat atau status pengembalian.</p>
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

                <form action="{{ route('pengembalian.update', $pengembalian) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id_alat">Alat</label>
                        <select name="id_alat" id="id_alat" class="form-control @error('id_alat') is-invalid @enderror" required>
                            <option value="">Pilih alat</option>
                            @foreach ($alat as $item)
                                <option value="{{ $item->id }}" @selected(old('id_alat', $pengembalian->id_alat) == $item->id)>
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
                            <option value="belum_dikembalikan" @selected(old('status', $pengembalian->status) === 'belum_dikembalikan')>Belum Dikembalikan</option>
                            <option value="sudah_dikembalikan" @selected(old('status', $pengembalian->status) === 'sudah_dikembalikan')>Sudah Dikembalikan</option>
                            <option value="terlambat" @selected(old('status', $pengembalian->status) === 'terlambat')>Terlambat</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
