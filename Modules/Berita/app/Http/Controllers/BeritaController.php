<?php
namespace Modules\Berita\Http\Controllers;
use Illuminate\Routing\Controller;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita::index');
    }
}
