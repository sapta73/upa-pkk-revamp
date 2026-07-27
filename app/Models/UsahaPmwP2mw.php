<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsahaPmwP2mw extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'usaha_pmw_p2mw';

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'nama_usaha',
        'nama_pemilik',
        'nim',
        'program',
        'jenis_usaha',
        'tahun_kegiatan',
        'modal_dana',
        'deskripsi',
        'foto',
        'sk_pendanaan',
        'status_aktif',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'tahun_kegiatan' => 'integer',
            'modal_dana' => 'decimal:2',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Scope untuk filter program PMW
     */
    public function scopePmw($query)
    {
        return $query->where('program', 'pmw');
    }

    /**
     * Scope untuk filter program P2MW
     */
    public function scopeP2mw($query)
    {
        return $query->where('program', 'p2mw');
    }

    /**
     * Scope hanya yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
