<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Konselor\Dashboard;

$middlewareKonselor = ['web', 'auth'];

if (config('upa.verifikasi_email')) {
    $middlewareKonselor[] = 'verified';
}

$middlewareKonselor[] = 'role:konselor';

Route::middleware($middlewareKonselor)->prefix('konselor')->name('konselor.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});
