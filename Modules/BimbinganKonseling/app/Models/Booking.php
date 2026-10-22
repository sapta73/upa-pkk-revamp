<?php
namespace Modules\BimbinganKonseling\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['kode_booking', 'user_id', 'konselor_id', 'nama_mahasiswa', 'nim', 'prodi', 'nomor_hp', 'email', 'tanggal', 'jam_sesi', 'mode', 'lokasi', 'deskripsi_masalah', 'status', 'link_meeting', 'catatan_konselor'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function konselor() { return $this->belongsTo(Konselor::class); }
    public function rating() { return $this->hasOne(Rating::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function permintaanReschedule() { return $this->hasMany(PermintaanReschedule::class); }
}
