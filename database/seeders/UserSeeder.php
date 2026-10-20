<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('89010'),
                'role' => 'admin'
            ],
            [
                'name' => 'Peminjam',
                'email' => 'peminjam@gmail.com',
                'password' => bcrypt('1234567'),
                'role' => 'peminjam'
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@worker.com',
                'password' => bcrypt('petugas123'),
                'role' => 'petugas'
            ]
        ]);


    }
}
