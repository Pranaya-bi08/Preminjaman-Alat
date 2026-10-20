<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'id_user',
        'id_alat',
        'id_petugas',
        'jumlah',
        'tanggal_pengajuan',
        'tanggal_kembali',
        'keperluan',
        'status',
        'catatan',
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }


    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }
}
