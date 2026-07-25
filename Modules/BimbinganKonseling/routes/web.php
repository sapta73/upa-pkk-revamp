<?php
use Illuminate\Support\Facades\Route;
use Modules\BimbinganKonseling\Http\Controllers\KonselingController;

Route::prefix('bimbingan-konseling')->name('bk.')->group(function () {
    Route::get('/', [KonselingController::class, 'index'])->name('index');
    Route::get('/konselor', [KonselingController::class, 'daftarKonselor'])->name('konselor');
    Route::get('/konselor/{id}', [KonselingController::class, 'profilKonselor'])->name('konselor.profil');
});
