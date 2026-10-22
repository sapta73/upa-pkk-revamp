<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\PendaftaranKegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(string $jenis)
    {
        abort_unless(in_array($jenis, ['workshop', 'seminar']), 404);

        $kegiatan = Kegiatan::aktif()
            ->where('jenis', $jenis)
            ->orderBy('tanggal_mulai')
            ->paginate(9);

        return view('kegiatan.index', compact('kegiatan', 'jenis'));
    }

    public function show(string $jenis, string $slug)
    {
        abort_unless(in_array($jenis, ['workshop', 'seminar']), 404);

        $kegiatan = Kegiatan::aktif()
            ->where('jenis', $jenis)
            ->where('slug', $slug)
            ->firstOrFail();

        $pendaftaran = null;

        if (auth()->check()) {
            $pendaftaran = PendaftaranKegiatan::where('kegiatan_id', $kegiatan->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        $jumlahPendaftar = $kegiatan->pendaftaran()
            ->whereIn('status', ['menunggu', 'diterima'])
            ->count();

        return view('kegiatan.show', compact('kegiatan', 'pendaftaran', 'jumlahPendaftar', 'jenis'));
    }

    public function daftar(Request $request, string $jenis, string $slug)
    {
        abort_unless(in_array($jenis, ['workshop', 'seminar']), 404);

        $kegiatan = Kegiatan::aktif()
            ->where('jenis', $jenis)
            ->where('slug', $slug)
            ->firstOrFail();

        $pengguna = $request->user();
        abort_unless(in_array($pengguna->role, ['mahasiswa', 'dosen', 'tendik']), 403, 'Role ini tidak dapat mendaftar kegiatan.');

        $sudah = PendaftaranKegiatan::where('kegiatan_id', $kegiatan->id)
            ->where('user_id', $pengguna->id)
            ->exists();

        if ($sudah) {
            return back()->with('gagal', 'Anda sudah terdaftar di kegiatan ini.');
        }

        if ($kegiatan->sisa_kuota !== null && $kegiatan->sisa_kuota <= 0) {
            return back()->with('gagal', 'Kuota kegiatan sudah penuh.');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:20'],
            'instansi' => ['nullable', 'string', 'max:255'],
        ]);

        if (blank($data['instansi'] ?? null)) {
            $data['instansi'] = $pengguna->role === 'mahasiswa' ? $pengguna->prodi : $pengguna->unit;
        }

        PendaftaranKegiatan::create([
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $pengguna->id,
            'nama' => $data['nama'],
            'email' => $data['email'],
            'nomor_hp' => $data['nomor_hp'],
            'instansi' => $data['instansi'],
            'status' => 'menunggu',
            'status_bayar' => $kegiatan->harga > 0 ? 'menunggu' : 'gratis',
            'status_hadir' => 'belum',
        ]);

        return back()->with('sukses', 'Pendaftaran berhasil. Silakan cek status pendaftaran Anda di halaman ini.');
    }

    public function unggahBukti(Request $request, string $jenis, string $slug)
    {
        abort_unless(in_array($jenis, ['workshop', 'seminar']), 404);

        $kegiatan = Kegiatan::aktif()
            ->where('jenis', $jenis)
            ->where('slug', $slug)
            ->firstOrFail();

        $pendaftaran = PendaftaranKegiatan::where('kegiatan_id', $kegiatan->id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($pendaftaran->status_bayar === 'lunas') {
            return back()->with('gagal', 'Pembayaran Anda sudah lunas.');
        }

        $request->validate([
            'bukti_bayar' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

        $pendaftaran->update([
            'bukti_bayar' => $path,
            'status_bayar' => 'menunggu',
        ]);

        return back()->with('sukses', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
