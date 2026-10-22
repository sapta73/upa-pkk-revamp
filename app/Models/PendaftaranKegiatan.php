<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranKegiatan extends Model
{
    protected $table = 'pendaftaran_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'user_id',
        'nama',
        'email',
        'nomor_hp',
        'instansi',
        'status',
        'status_bayar',
        'bukti_bayar',
        'status_hadir',
        'catatan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    public function getLabelBayarAttribute(): string
    {
        return match ($this->status_bayar) {
            'lunas' => 'Lunas',
            'menunggu' => 'Menunggu Verifikasi',
            default => 'Gratis',
        };
    }

    public function getLabelHadirAttribute(): string
    {
        return match ($this->status_hadir) {
            'hadir' => 'Hadir',
            'tidak_hadir' => 'Tidak Hadir',
            default => 'Belum Hadir',
        };
    }
}
