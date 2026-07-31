<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Konselor\Dashboard;

Route::middleware(['web', 'auth', 'role:konselor'])->prefix('konselor')->name('konselor.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});
