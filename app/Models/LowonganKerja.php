<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganKerja extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'lowongan_kerja';

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'judul',
        'perusahaan',
        'posisi',
        'lokasi',
        'tipe_pekerjaan',
        'deskripsi',
        'persyaratan',
        'gaji',
        'kuota',
        'batas_lamaran',
        'link_pendaftaran',
        'kontak',
        'status_aktif',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'kuota' => 'integer',
            'batas_lamaran' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Scope hanya lowongan yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Scope hanya lowongan yang masih buka pendaftaran (belum lewat batas).
     * Jika batas_lamaran kosong, dianggap masih buka.
     */
    public function scopeMasihBuka($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('batas_lamaran')
              ->orWhere('batas_lamaran', '>=', now()->toDateString());
        });
    }

    /**
     * Label tipe pekerjaan dalam Bahasa Indonesia.
     */
    public function getLabelTipeAttribute(): string
    {
        return match ($this->tipe_pekerjaan) {
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'magang' => 'Magang',
            'kontrak' => 'Kontrak',
            default => ucfirst($this->tipe_pekerjaan),
        };
    }
}
