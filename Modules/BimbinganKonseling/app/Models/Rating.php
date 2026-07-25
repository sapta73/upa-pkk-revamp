<?php
namespace Modules\BimbinganKonseling\Models;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = ['booking_id', 'konselor_id', 'nim_mahasiswa', 'rating', 'komentar'];

    public function booking() { return $this->belongsTo(Booking::class); }
    public function konselor() { return $this->belongsTo(Konselor::class); }
}
