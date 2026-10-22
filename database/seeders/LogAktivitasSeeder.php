<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LogAktivitas;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $now = now();

            LogAktivitas::create([
                'id_user' => 1,
                'nama' => 'Admin',
                'role' => 'admin',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);

             LogAktivitas::create([
                'id_user' => 2,
                     'nama' => 'Peminjam',
                     'role' => 'peminjam',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);

             LogAktivitas::create([
                'id_user' => 3,
                     'nama' => 'Petugas',
                     'role' => 'petugas',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);


    }
}
