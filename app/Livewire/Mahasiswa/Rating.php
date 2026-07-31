<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\BimbinganKonseling\Models\Booking;

#[Layout('layouts.livewire')]
class Rating extends Component
{
    public $booking;
    public $rating = 5;
    public $komentar = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string|max:500',
    ];

    public function mount($id)
    {
        // RBAC: hanya pemilik booking yang bisa memberi rating
        $this->booking = Booking::with('konselor')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Hanya booking berstatus selesai yang bisa dirating
        abort_unless($this->booking->status === 'selesai', 403, 'Booking belum selesai, belum bisa diberi rating.');

        // Cegah rating ganda
        abort_if($this->booking->rating()->exists(), 403, 'Booking ini sudah diberi rating.');
    }

    public function setRating($nilai)
    {
        $this->rating = (int) $nilai;
    }

    public function simpan()
    {
        $this->validate();

        // Validasi ulang di sisi server (double check RBAC)
        abort_unless($this->booking->user_id === auth()->id(), 403);
        abort_unless($this->booking->status === 'selesai', 403);
        abort_if($this->booking->rating()->exists(), 403);

        \Modules\BimbinganKonseling\Models\Rating::create([
            'booking_id' => $this->booking->id,
            'konselor_id' => $this->booking->konselor_id,
            'nim_mahasiswa' => auth()->user()->nim,
            'rating' => $this->rating,
            'komentar' => $this->komentar,
        ]);

        session()->flash('sukses', 'Terima kasih! Rating kamu berhasil disimpan.');

        return redirect()->route('mahasiswa.my-booking');
    }

    public function render()
    {
        return view('livewire.mahasiswa.rating');
    }
}
