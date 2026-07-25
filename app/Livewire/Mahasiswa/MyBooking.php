<?php
namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use Modules\BimbinganKonseling\Models\Booking;
use Modules\BimbinganKonseling\Models\Rating;

class MyBooking extends Component
{
    public $tab = 'aktif';

    public function batalkan($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $booking->update(['status' => 'dibatalkan']);
    }

    public function render()
    {
        $bookings = Booking::with('konselor')
            ->where('user_id', auth()->id())
            ->when($this->tab == 'aktif', fn($q) => $q->whereIn('status', ['menunggu', 'disetujui']))
            ->when($this->tab == 'riwayat', fn($q) => $q->whereIn('status', ['selesai', 'dibatalkan', 'ditolak']))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.mahasiswa.my-booking', compact('bookings'));
    }
}
