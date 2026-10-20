<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamController;

route::get('/', function () {
    return redirect()->route('login');
});

   Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
   Route::post('/actionLogin', [LoginController::class, 'actionLogin'])->name('actionLogin');

Route::middleware(['auth'])->group(function() {
   Route::post('/logout', [LoginController::class, 'actionLogout'])->name('logout');
});

   Route::middleware(['auth', 'role:admin'])->group(function () {
        route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

       Route::get('/user', [UserController::class, 'index'])->name('user.index');
       Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');
       Route::post('/user/simpan', [UserController::class, 'store'])->name('user.store');
       Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
       Route::post('/user/update{id}', [UserController::class, 'update'])->name('user.update');
       Route::get('/user/hapus{id}', [UserController::class, 'destroy'])->name('user.destroy');


       Route::get('/alat', [AlatController::class,'index'])->name('alat.index');
       Route::get('/alat/tambah', [AlatController::class,'create'])->name('alat.create');
       Route::post('/alat/simpan', [AlatController::class,'store'])->name('alat.store');
       Route::get('/alat/edit/{id}', [AlatController::class,'edit'])->name('alat.edit');
       Route::post('/alat/update/{id}', [AlatController::class,'update'])->name('alat.update');
       Route::get('/alat/hapus{id}', [AlatController::class,'destroy'])->name('alat.destroy');

       Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
       Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.create');
       Route::post('/kategori/simpan', [KategoriController::class, 'store'])->name('kategori.store');
       Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
       Route::post('/kategori/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
       Route::delete('/kategori/hapus/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

       Route::get('/peminjaman', [PeminjamanController::class,'index'])->name('peminjaman.index');
        Route::get('peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::post('peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::get('peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

       Route::get('/pengembalian', [PengembalianController::class,'index'])->name('pengembalian.index');
       Route::get('/pengembalian/tambah', [PengembalianController::class, 'create'])->name('pengembalian.create');
       Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
       Route::get('/pengembalian/{pengembalian}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
       Route::put('/pengembalian/{pengembalian}', [PengembalianController::class, 'update'])->name('pengembalian.update');
       Route::delete('/pengembalian/{pengembalian}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');
       Route::get('/log-aktivitas', [LogAktivitasController::class,'index'])->name('log.index');
   });

   Route::middleware(['auth', 'role:petugas'])->group(function () {
       Route::get('/petugas/dashboard', fn () => view('petugas.dashboard'))->name('petugas.dashboard');

        Route::post('peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::get('laporan/peminjaman', [PeminjamanController::class, 'laporan'])->name('peminjaman.laporan');
   });

   Route::middleware(['auth', 'role:peminjam'])->group(function () {
       Route::get('/peminjam/dashboard', [PeminjamController::class, 'dashboard'])->name('peminjam.dashboard');
       Route::get('/peminjam/alat', [PeminjamController::class, 'alat'])->name('peminjam.alat.index');
       Route::get('/peminjam/pengajuan', [PeminjamController::class, 'pengajuan'])->name('peminjam.pengajuan.index');
       Route::get('/peminjam/pengembalian', [PeminjamController::class, 'pengembalian'])->name('peminjam.pengembalian.index');

       Route::post('/peminjam/pengajuan', [PeminjamController::class, 'storePengajuan'])->name('peminjam.pengajuan.store');
       Route::post('/peminjam/pengembalian/{id}', [PeminjamController::class, 'kembalikan'])->name('peminjam.kembalikan');

       // Compatibility / aliases
       Route::get('peminjaman/create', [PeminjamController::class, 'alat'])->name('peminjaman.create');
       Route::post('peminjaman', [PeminjamController::class, 'storePengajuan'])->name('peminjaman.store');
   });
