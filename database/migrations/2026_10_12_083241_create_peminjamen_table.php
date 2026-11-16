<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();             // peminjam
            $table->foreignId('id_alat')->constrained('alats')->cascadeOnDelete();
            $table->foreignId('id_petugas')->nullable()->constrained('users')->nullOnDelete(); // yang memproses
            $table->unsignedInteger('jumlah')->default(1);
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_kembali');            // rencana pengembalian
            $table->text('keperluan')->nullable();      // diisi peminjam
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();        // diisi petugas (mis. alasan penolakan)
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};