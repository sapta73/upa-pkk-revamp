<?php
namespace Modules\BimbinganKonseling\Models;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';
    protected $fillable = ['konselor_id', 'hari', 'jam_mulai', 'jam_selesai', 'kuota', 'status_aktif'];

    public function konselor() { return $this->belongsTo(Konselor::class); }
}
