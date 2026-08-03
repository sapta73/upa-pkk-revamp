<?php

use Illuminate\Support\Facades\Route;
use Modules\BimbinganKonseling\Http\Controllers\KonselingController;
use App\Http\Controllers\Wirausaha\UsahaController;
use App\Http\Controllers\Lowongan\LowonganKerjaController;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

Route::get('/bimbingan-konseling', [KonselingController::class, 'index'])->name('bk.index');
Route::get('/bimbingan-konseling/konselor', [KonselingController::class, 'daftarKonselor'])->name('bk.konselor');
Route::get('/bimbingan-konseling/konselor/{id}', [KonselingController::class, 'profilKonselor'])->name('bk.konselor.profil');

// Routes Wirausaha (PMW & P2MW)
Route::prefix('wirausaha')->name('wirausaha.')->group(function () {
    Route::get('/', [UsahaController::class, 'landing'])->name('landing');
    Route::get('/daftar-usaha', [UsahaController::class, 'index'])->name('index');
    Route::get('/{id}', [UsahaController::class, 'show'])->name('show');
});

// Routes Lowongan Kerja
Route::prefix('lowongan-kerja')->name('lowongan.')->group(function () {
    Route::get('/', [LowonganKerjaController::class, 'index'])->name('index');
    Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
});

require __DIR__.'/auth.php';
