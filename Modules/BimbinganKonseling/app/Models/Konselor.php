<?php
namespace Modules\BimbinganKonseling\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    protected $table = 'konselors';
    protected $fillable = ['id_konselor', 'user_id', 'nama', 'nip', 'spesialisasi', 'bio', 'foto', 'nomor_hp', 'email', 'status_aktif'];

    public function jadwals() { return $this->hasMany(Jadwal::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
    public function user() { return $this->belongsTo(User::class); }

    /**
     * Rata-rata rating dari data rating yang nyata.
     */
    public function getRatingRataAttribute(): string
    {
        return number_format((float) $this->ratings()->avg('rating'), 1);
    }

    /**
     * Jumlah rating yang nyata.
     */
    public function getJumlahRatingAttribute(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Link WhatsApp (wa.me) dari nomor HP konselor.
     * Nomor lokal 08xx otomatis dikonversi ke format internasional 62xx.
     */
    public function getLinkWaAttribute(): ?string
    {
        if (blank($this->nomor_hp)) {
            return null;
        }

        $nomor = preg_replace('/\D/', '', $this->nomor_hp);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (!str_starts_with($nomor, '62')) {
            $nomor = '62' . $nomor;
        }

        return 'https://wa.me/' . $nomor . '?text=' . rawurlencode('Halo, saya ingin konsultasi bimbingan konseling dengan ' . $this->nama . '.');
    }
}
