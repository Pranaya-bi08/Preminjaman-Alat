<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DISETUJUI = 'disetujui';
    public const STATUS_DITOLAK = 'ditolak';

    protected $table = 'peminjaman';

    protected $fillable = [
        'id_user',
        'id_alat',
        'id_petugas',
        'jumlah',
        'tanggal_pengajuan',
        'tanggal_kembali',
        'keperluan',
        'status',
        'catatan',
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function isSudahDikembalikan(): bool
    {
        return !empty($this->catatan) && str_contains($this->catatan, '[DIKEMBALIKAN');
    }

    public function isTerlambat(): bool
    {
        if ($this->status !== self::STATUS_DISETUJUI || $this->isSudahDikembalikan()) {
            return false;
        }

        return \Carbon\Carbon::parse($this->tanggal_kembali)->isPast() && !\Carbon\Carbon::parse($this->tanggal_kembali)->isToday();
    }
}
