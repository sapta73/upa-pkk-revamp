<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\LowonganKerja;

class KarierController extends Controller
{
    public function index()
    {
        $workshop = Kegiatan::aktif()->workshop()->orderBy('tanggal_mulai')->take(3)->get();
        $seminar = Kegiatan::aktif()->seminar()->orderBy('tanggal_mulai')->take(3)->get();
        $lowongan = LowonganKerja::where('status_aktif', true)->latest()->take(3)->get();

        return view('karier.index', compact('workshop', 'seminar', 'lowongan'));
    }
}
