<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'stok'
    ];

    public function alat()
    {
        return $this->hasMany(Alat::class, 'id_kategori','id');
    }

    public function alats()
    {
        return $this->hasMany(Alat::class, 'id_kategori','id');
    }
}
