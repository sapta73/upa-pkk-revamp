<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranProgram extends Model
{
    protected $table = 'pendaftaran_program';

    protected $fillable = [
        'user_id',
        'program',
        'nama_tim',
        'ketua',
        'anggota',
        'judul_usaha',
        'deskripsi',
        'link_proposal',
        'status',
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLabelProgramAttribute(): string
    {
        return match ($this->program) {
            'pmw' => 'PMW',
            'p2mw' => 'P2MW',
            'klk' => 'KLK',
            default => strtoupper($this->program),
        };
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Menunggu',
        };
    }
}
