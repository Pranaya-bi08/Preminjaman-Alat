<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'stok' => 10],
            ['nama_kategori' => 'ATK', 'stok' => 20],
            ['nama_kategori' => 'Furniture', 'stok' => 15]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
