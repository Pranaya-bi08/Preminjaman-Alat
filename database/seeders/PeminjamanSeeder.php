<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $peminjam = User::where('role', 'peminjam')->get();
        $petugas  = User::where('role', 'petugas')->first();
        $alat     = Alat::all();

        if ($peminjam->isEmpty() || ! $petugas || $alat->isEmpty()) {
            $this->command?->warn(
                'Seeder dilewati: pastikan data user (peminjam & petugas) dan alat sudah ada.'
            );
            return;
        }

        $work = [
            ['status' => 'menunggu',  'ajuan' => 0,  'kembali' => 3, 'keperluan' => 'Untuk praktikum jaringan',        'catatan' => null],
            ['status' => 'menunggu',  'ajuan' => -1, 'kembali' => 4, 'keperluan' => 'Dokumentasi kegiatan sekolah',    'catatan' => null],
            ['status' => 'disetujui', 'ajuan' => -3, 'kembali' => 2, 'keperluan' => 'Kegiatan ekstrakurikuler',        'catatan' => null],
            ['status' => 'disetujui', 'ajuan' => -7, 'kembali' => -1,'keperluan' => 'Proyek akhir semester',           'catatan' => null],
            ['status' => 'ditolak',   'ajuan' => -5, 'kembali' => -2,'keperluan' => 'Keperluan pribadi',               'catatan' => 'Alat sedang tidak tersedia.'],
        ];

        foreach ($work as $i => $row) {
            $diproses = $row['status'] !== 'menunggu';

            Peminjaman::create([
                'id_user'    => $peminjam[$i % $peminjam->count()]->id,
                'id_alat'    => $alat[$i % $alat->count()]->id,
                'id_petugas' => $diproses ? $petugas->id : null,
                'jumlah'            => 1,
                'tanggal_pengajuan' => now()->addDays($row['ajuan'])->toDateString(),
                'tanggal_kembali'   => now()->addDays($row['kembali'])->toDateString(),
                'keperluan'         => $row['keperluan'],
                'status'            => $row['status'],
                'catatan'           => $row['catatan'],
            ]);
        }
    }
}