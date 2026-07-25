<?php

use Illuminate\Support\Facades\Route;
use Modules\BimbinganKonseling\Http\Controllers\KonselingController;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

Route::get('/bimbingan-konseling', [KonselingController::class, 'index'])->name('bk.index');
Route::get('/bimbingan-konseling/konselor', [KonselingController::class, 'daftarKonselor'])->name('bk.konselor');
Route::get('/bimbingan-konseling/konselor/{id}', [KonselingController::class, 'profilKonselor'])->name('bk.konselor.profil');

require __DIR__.'/auth.php';
