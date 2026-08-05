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
}
