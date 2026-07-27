<?php

namespace App\Http\Controllers\Wirausaha;

use App\Http\Controllers\Controller;
use App\Models\UsahaPmwP2mw;
use Illuminate\Http\Request;

class UsahaController extends Controller
{
    /**
     * Menampilkan daftar semua usaha PMW/P2MW
     */
    public function index(Request $request)
    {
        $query = UsahaPmwP2mw::aktif();

        // Filter berdasarkan program (PMW / P2MW)
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_kegiatan', $request->tahun);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        $usahaList = $query->latest()->paginate(12);

        // Data untuk filter
        $tahunList = UsahaPmwP2mw::aktif()
            ->select('tahun_kegiatan')
            ->distinct()
            ->whereNotNull('tahun_kegiatan')
            ->orderBy('tahun_kegiatan', 'desc')
            ->pluck('tahun_kegiatan');

        return view('wirausaha.index', compact('usahaList', 'tahunList'));
    }

    /**
     * Menampilkan detail satu usaha
     */
    public function show($id)
    {
        $usaha = UsahaPmwP2mw::aktif()->findOrFail($id);
        return view('wirausaha.show', compact('usaha'));
    }

    /**
     * Halaman landing wirausaha
     */
    public function landing()
    {
        $totalPmw = UsahaPmwP2mw::aktif()->pmw()->count();
        $totalP2mw = UsahaPmwP2mw::aktif()->p2mw()->count();
        $totalUsaha = UsahaPmwP2mw::aktif()->count();
        $usahaTerbaru = UsahaPmwP2mw::aktif()->latest()->take(6)->get();

        return view('wirausaha.landing', compact('totalPmw', 'totalP2mw', 'totalUsaha', 'usahaTerbaru'));
    }
}
