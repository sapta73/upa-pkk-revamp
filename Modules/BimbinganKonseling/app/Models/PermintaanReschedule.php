<?php

namespace Modules\BimbinganKonseling\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PermintaanReschedule extends Model
{
    protected $table = 'permintaan_reschedules';

    protected $fillable = [
        'booking_id',
        'user_id',
        'jadwal_id',
        'tanggal_baru',
        'jam_baru',
        'alasan',
        'status',
        'catatan_konselor',
    ];

    protected $casts = [
        'tanggal_baru' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Menunggu',
        };
    }
}
