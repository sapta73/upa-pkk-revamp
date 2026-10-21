<?php

namespace App\Filament\Resources\BkResource\Concerns;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Modules\BimbinganKonseling\Models\Konselor;

trait MengelolaAkunKonselor
{
    protected function periksaAkunKonselor(?int $idKonselor = null): void
    {
        $email = $this->data['email'] ?? null;
        $password = $this->data['password_akun'] ?? null;
        $userId = $this->data['user_id'] ?? null;

        if (filled($userId)) {
            return;
        }

        if (blank($password)) {
            return;
        }

        if (blank($email)) {
            throw ValidationException::withMessages([
                'email' => 'Email wajib diisi untuk membuat akun login.',
            ]);
        }

        $pengguna = User::where('email', $email)->first();

        if (!$pengguna) {
            return;
        }

        $sudahDipakai = Konselor::where('user_id', $pengguna->id)
            ->when($idKonselor, fn ($query) => $query->whereKeyNot($idKonselor))
            ->exists();

        if ($pengguna->role !== 'konselor' || $sudahDipakai) {
            throw ValidationException::withMessages([
                'email' => 'Email sudah dipakai akun lain.',
            ]);
        }
    }

    protected function tautkanAkunKonselor(): void
    {
        $password = $this->data['password_akun'] ?? null;
        $userId = $this->data['user_id'] ?? null;

        if (filled($userId)) {
            $pengguna = User::find($userId);

            if ($pengguna && filled($password)) {
                $pengguna->update(['password' => $password]);
            }

            $this->record->update(['user_id' => $userId]);

            return;
        }

        if (blank($password)) {
            return;
        }

        $pengguna = User::where('email', $this->data['email'])->first();

        if ($pengguna) {
            $pengguna->update(['password' => $password]);
        } else {
            $pengguna = User::create([
                'name' => $this->data['nama'],
                'email' => $this->data['email'],
                'password' => $password,
                'role' => 'konselor',
            ]);
        }

        $this->record->update(['user_id' => $pengguna->id]);
    }
}
