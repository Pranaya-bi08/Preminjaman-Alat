<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->string('aktivitas')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropColumn(['aktivitas', 'keterangan', 'tanggal']);
        });
    }
};
