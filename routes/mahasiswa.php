<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Mahasiswa\BookingForm;
use App\Livewire\Mahasiswa\MyBooking;

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/booking/{id?}', BookingForm::class)->name('booking');
    Route::get('/my-booking', MyBooking::class)->name('my-booking');
});
