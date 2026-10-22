<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\BimbinganKonseling\Models\Konselor;

#[Fillable(['name', 'email', 'password', 'role', 'nim', 'nip', 'prodi', 'unit', 'nomor_hp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function konselor()
    {
        return $this->hasOne(Konselor::class);
    }

    public function pendaftaranKegiatan()
    {
        return $this->hasMany(\App\Models\PendaftaranKegiatan::class);
    }

    public function pendaftaranProgram()
    {
        return $this->hasMany(\App\Models\PendaftaranProgram::class);
    }
}
