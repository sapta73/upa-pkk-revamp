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

            if ($pengguna) {
                if (filled($password)) {
                    $pengguna->update(['password' => $password]);
                }

                if (!$pengguna->hasVerifiedEmail()) {
                    $pengguna->email_verified_at = now();
                    $pengguna->save();
                }

                $this->record->update(['user_id' => $pengguna->id]);
            }

            return;
        }

        if (blank($password)) {
            return;
        }

        $pengguna = User::where('email', $this->data['email'])->first();

        if ($pengguna) {
            $pengguna->update(['password' => $password]);

            if (!$pengguna->hasVerifiedEmail()) {
                $pengguna->email_verified_at = now();
                $pengguna->save();
            }
        } else {
            $pengguna = User::create([
                'name' => $this->data['nama'],
                'email' => $this->data['email'],
                'password' => $password,
                'role' => 'konselor',
            ]);
            $pengguna->email_verified_at = now();
            $pengguna->save();
        }

        $this->record->update(['user_id' => $pengguna->id]);
    }

    protected function sinkronkanDataKonselor(): void
    {
        if (blank($this->record->user_id)) {
            return;
        }

        $pengguna = User::find($this->record->user_id);

        if (!$pengguna) {
            return;
        }

        $emailLama = $pengguna->email;
        $pengguna->name = $this->record->nama;
        $pengguna->email = $this->record->email;
        $pengguna->nomor_hp = $this->record->nomor_hp;

        if ($pengguna->email !== $emailLama) {
            $pengguna->email_verified_at = null;
        }

        $pengguna->save();
    }
}
