<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerbaruiProfilRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Modules\BimbinganKonseling\Models\Konselor;

class ProfilController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profil.edit', [
            'pengguna' => $request->user(),
        ]);
    }

    public function update(PerbaruiProfilRequest $request): RedirectResponse
    {
        $pengguna = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($pengguna, $data) {
            $emailLama = $pengguna->email;
            $pengguna->fill($data);

            if ($pengguna->email !== $emailLama) {
                $pengguna->email_verified_at = null;
            }

            $pengguna->save();

            if ($pengguna->role === 'konselor') {
                $konselor = Konselor::where('user_id', $pengguna->id)->first();

                if ($konselor) {
                    $konselor->update([
                        'nama' => $pengguna->name,
                        'email' => $pengguna->email,
                        'nomor_hp' => $pengguna->nomor_hp,
                    ]);
                }
            }
        });

        return Redirect::route('profil.edit')->with('status', 'profil-diperbarui');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $pengguna = $request->user();

        abort_unless($pengguna->role === 'mahasiswa', 403, 'Hanya mahasiswa yang dapat menghapus akun.');

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();
        $pengguna->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
