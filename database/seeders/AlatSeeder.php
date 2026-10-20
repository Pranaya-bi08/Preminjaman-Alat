<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alats')->insert([
            [
                'id_kategori' => 1,
                'nama_alat' => 'Laptop',
                'stok' => 10,

            ],
            [
                'id_kategori' => 1,
                'nama_alat' => 'Proyektor',
                'stok' => 3,
            ],
        ]);
    }
}
