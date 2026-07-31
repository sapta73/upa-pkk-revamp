<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Livewire::component('mahasiswa.booking-form', \App\Livewire\Mahasiswa\BookingForm::class);
        Livewire::component('mahasiswa.my-booking', \App\Livewire\Mahasiswa\MyBooking::class);
        Livewire::component('mahasiswa.rating', \App\Livewire\Mahasiswa\Rating::class);
        Livewire::component('konselor.dashboard', \App\Livewire\Konselor\Dashboard::class);
    }
}
