<?php

namespace App\Http\Controllers\Lowongan;

use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use Illuminate\Http\Request;

class LowonganKerjaController extends Controller
{
    /**
     * Menampilkan daftar lowongan pekerjaan yang masih aktif & terbuka.
     */
    public function index(Request $request)
    {
        $query = LowonganKerja::aktif();

        // Filter berdasarkan tipe pekerjaan
        if ($request->filled('tipe')) {
            $query->where('tipe_pekerjaan', $request->tipe);
        }

        // Filter lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', "%{$request->lokasi}%");
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('perusahaan', 'like', "%{$search}%")
                  ->orWhere('posisi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $lowonganList = $query->latest()->paginate(9)->withQueryString();

        // Data untuk filter
        $daftarLokasi = LowonganKerja::aktif()
            ->select('lokasi')
            ->distinct()
            ->whereNotNull('lokasi')
            ->pluck('lokasi');

        return view('lowongan.index', compact('lowonganList', 'daftarLokasi'));
    }

    /**
     * Menampilkan detail satu lowongan.
     */
    public function show($id)
    {
        $lowongan = LowonganKerja::aktif()->findOrFail($id);

        // Lowongan lain yang masih relevan (perusahaan sama atau terbaru)
        $lowonganLainnya = LowonganKerja::aktif()
            ->where('id', '!=', $lowongan->id)
            ->where('perusahaan', $lowongan->perusahaan)
            ->latest()
            ->take(3)
            ->get();

        if ($lowonganLainnya->isEmpty()) {
            $lowonganLainnya = LowonganKerja::aktif()
                ->where('id', '!=', $lowongan->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('lowongan.show', compact('lowongan', 'lowonganLainnya'));
    }
}
