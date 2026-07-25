<?php
namespace Modules\BimbinganKonseling\Http\Controllers;
use Illuminate\Routing\Controller;
use Modules\BimbinganKonseling\Models\Konselor;

class KonselingController extends Controller
{
    public function index()
    {
        $konselors = Konselor::where('status_aktif', true)->get();
        return view('bk.index', compact('konselors'));
    }

    public function daftarKonselor()
    {
        $konselors = Konselor::where('status_aktif', true)->get();
        return view('bk.daftar-konselor', compact('konselors'));
    }

    public function profilKonselor($id)
    {
        $konselor = Konselor::with('jadwals')->findOrFail($id);
        return view('bk.profil-konselor', compact('konselor'));
    }
}
