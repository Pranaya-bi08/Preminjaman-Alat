<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'id_alat',
        'id_kategori',
        'status',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
