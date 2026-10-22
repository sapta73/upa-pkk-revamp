<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerbaruiProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pengguna = $this->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($pengguna->id),
            ],
            'nim' => $pengguna->role === 'mahasiswa'
                ? ['required', 'string', 'max:20', Rule::unique(User::class, 'nim')->ignore($pengguna->id)]
                : ['nullable'],
            'prodi' => $pengguna->role === 'mahasiswa'
                ? ['required', 'string', Rule::in(config('upa.prodi'))]
                : ['nullable'],
            'nip' => in_array($pengguna->role, ['dosen', 'tendik'])
                ? ['required', 'string', 'max:30', Rule::unique(User::class, 'nip')->ignore($pengguna->id)]
                : ['nullable'],
            'unit' => in_array($pengguna->role, ['dosen', 'tendik'])
                ? ['required', 'string', 'max:100']
                : ['nullable'],
            'nomor_hp' => in_array($pengguna->role, ['mahasiswa', 'konselor'])
                ? ['required', 'string', 'max:15']
                : ['nullable'],
        ];
    }
}
