<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $now = now();
        
            LogAktivitas::create([
                'user_id' => 1,
                'nama' => 'Admin',
                'role' => 'admin',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);

             LogAktivitas::create([
                'user_id' => 2,
                'nama' => 'Petugas',
                'role' => 'petugas',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);
            
             LogAktivitas::create([
                'user_id' => 3,
                'nama' => 'Peminjam',
                'role' => 'peminjam',
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'User login berhasil',
                'tanggal' => $now,
            ]);


    }
}
