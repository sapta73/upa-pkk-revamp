<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Mahasiswa\BookingForm;
use App\Livewire\Mahasiswa\MyBooking;
use App\Livewire\Mahasiswa\Rating;

$middlewareMahasiswa = ['web', 'auth'];

if (config('upa.verifikasi_email')) {
    $middlewareMahasiswa[] = 'verified';
}

$middlewareMahasiswa[] = 'role:mahasiswa';

Route::middleware($middlewareMahasiswa)->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/booking/{id?}', BookingForm::class)->name('booking');
    Route::get('/my-booking', MyBooking::class)->name('my-booking');
    Route::get('/rating/{id}', Rating::class)->name('rating');
});
