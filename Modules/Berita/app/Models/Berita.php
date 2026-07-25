<?php
namespace Modules\Berita\Models;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $fillable = ['judul', 'slug', 'isi', 'gambar', 'penulis', 'status'];
}
