<?php

use Illuminate\Support\Facades\Route;
use Modules\BimbinganKonseling\Http\Controllers\KonselingController;
use App\Http\Controllers\Wirausaha\UsahaController;
use App\Http\Controllers\Lowongan\LowonganKerjaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KarierController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProgramController;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

Route::get('/bimbingan-konseling', [KonselingController::class, 'index'])->name('bk.index');
Route::get('/bimbingan-konseling/konselor', [KonselingController::class, 'daftarKonselor'])->name('bk.konselor');
Route::get('/bimbingan-konseling/konselor/{id}', [KonselingController::class, 'profilKonselor'])->name('bk.konselor.profil');

Route::prefix('wirausaha')->name('wirausaha.')->group(function () {
    Route::get('/', [UsahaController::class, 'landing'])->name('landing');
    Route::get('/daftar-usaha', [UsahaController::class, 'index'])->name('index');

    Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
        Route::get('/daftar-program', [ProgramController::class, 'create'])->name('program.create');
        Route::post('/daftar-program', [ProgramController::class, 'store'])->name('program.store');
    });

    Route::get('/{id}', [UsahaController::class, 'show'])->name('show');
});

Route::prefix('lowongan-kerja')->name('lowongan.')->group(function () {
    Route::get('/', [LowonganKerjaController::class, 'index'])->name('index');
    Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
});

Route::get('/karier', [KarierController::class, 'index'])->name('karier.index');
Route::get('/karier/{jenis}', [KegiatanController::class, 'index'])
    ->whereIn('jenis', ['workshop', 'seminar'])
    ->name('kegiatan.index');
Route::get('/karier/{jenis}/{slug}', [KegiatanController::class, 'show'])
    ->whereIn('jenis', ['workshop', 'seminar'])
    ->name('kegiatan.show');

Route::middleware(['auth', 'role:mahasiswa,dosen,tendik'])->group(function () {
    Route::post('/karier/{jenis}/{slug}/daftar', [KegiatanController::class, 'daftar'])
        ->whereIn('jenis', ['workshop', 'seminar'])
        ->name('kegiatan.daftar');
    Route::post('/karier/{jenis}/{slug}/bukti-bayar', [KegiatanController::class, 'unggahBukti'])
        ->whereIn('jenis', ['workshop', 'seminar'])
        ->name('kegiatan.bukti');
});

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect('/admin'),
        'konselor' => redirect('/konselor/dashboard'),
        default => redirect('/mahasiswa/my-booking'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::patch('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil', [ProfilController::class, 'destroy'])->name('profil.destroy');
});

require __DIR__.'/auth.php';
