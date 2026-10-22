<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function create(Request $request)
    {
        abort_unless($request->user()->role === 'mahasiswa', 403);

        $pendaftaran = PendaftaranProgram::where('user_id', $request->user()->id)
            ->get()
            ->keyBy('program');

        return view('program.daftar', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->role === 'mahasiswa', 403);

        $data = $request->validate([
            'program' => ['required', Rule::in(['pmw', 'p2mw', 'klk'])],
            'nama_tim' => ['required', 'string', 'max:255'],
            'ketua' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string', 'max:2000'],
            'judul_usaha' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:3000'],
            'link_proposal' => ['required', 'url', 'max:255'],
        ]);

        $sudah = PendaftaranProgram::where('user_id', $request->user()->id)
            ->where('program', $data['program'])
            ->exists();

        if ($sudah) {
            return back()->with('gagal', 'Anda sudah mendaftar di program ini.');
        }

        PendaftaranProgram::create([
            'user_id' => $request->user()->id,
            'program' => $data['program'],
            'nama_tim' => $data['nama_tim'],
            'ketua' => $data['ketua'],
            'anggota' => $data['anggota'] ?? null,
            'judul_usaha' => $data['judul_usaha'],
            'deskripsi' => $data['deskripsi'],
            'link_proposal' => $data['link_proposal'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('wirausaha.program.create')->with('sukses', 'Pendaftaran program berhasil dikirim.');
    }
}
