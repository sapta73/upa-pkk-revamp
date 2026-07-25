<?php
namespace Modules\BimbinganKonseling\Models;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    protected $table = 'konselors';
    protected $fillable = ['id_konselor', 'nama', 'nip', 'spesialisasi', 'bio', 'foto', 'nomor_hp', 'email', 'status_aktif'];

    public function jadwals() { return $this->hasMany(Jadwal::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
}
