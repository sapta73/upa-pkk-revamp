<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'jenis',
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'harga',
        'instruksi_bayar',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'wajib',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'wajib' => 'boolean',
        'status_aktif' => 'boolean',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranKegiatan::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function scopeWorkshop($query)
    {
        return $query->where('jenis', 'workshop');
    }

    public function scopeSeminar($query)
    {
        return $query->where('jenis', 'seminar');
    }

    public function getLabelHargaAttribute(): string
    {
        return $this->harga > 0 ? 'Rp '.number_format($this->harga, 0, ',', '.') : 'Gratis';
    }

    public function getSisaKuotaAttribute(): ?int
    {
        if ($this->kuota <= 0) {
            return null;
        }

        return max(0, $this->kuota - $this->pendaftaran()->whereIn('status', ['menunggu', 'diterima'])->count());
    }
}
