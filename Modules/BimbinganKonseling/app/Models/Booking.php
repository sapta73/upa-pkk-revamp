<?php
namespace Modules\BimbinganKonseling\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['kode_booking', 'konselor_id', 'nama_mahasiswa', 'nim', 'prodi', 'nomor_hp', 'email', 'tanggal', 'jam_sesi', 'deskripsi_masalah', 'status', 'link_meeting', 'catatan_konselor'];

    public function konselor() { return $this->belongsTo(Konselor::class); }
    public function rating() { return $this->hasOne(Rating::class); }
}
