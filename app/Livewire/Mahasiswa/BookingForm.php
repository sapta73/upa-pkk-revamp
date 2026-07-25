<?php
namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use Modules\BimbinganKonseling\Models\Konselor;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\Booking;

class BookingForm extends Component
{
    public $konselorId;
    public $konselor;
    public $jadwals = [];
    public $selectedJadwal;
    public $tanggal;
    public $jamSesi;
    public $deskripsiMasalah;
    public $step = 1;
    public $bookingBerhasil = false;
    public $kodeBooking;

    protected $rules = [
        'selectedJadwal' => 'required',
        'tanggal' => 'required|date|after:today',
        'deskripsiMasalah' => 'required|min:10',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->konselorId = $id;
            $this->konselor = Konselor::with('jadwals')->findOrFail($id);
            $this->jadwals = $this->konselor->jadwals->where('status_aktif', true);
            $this->step = 2;
        }
    }

    public function pilihKonselor($id)
    {
        $this->konselorId = $id;
        $this->konselor = Konselor::with('jadwals')->findOrFail($id);
        $this->jadwals = $this->konselor->jadwals->where('status_aktif', true);
        $this->step = 2;
    }

    public function booking()
    {
        $this->validate();
        $jadwal = Jadwal::findOrFail($this->selectedJadwal);
        $user = auth()->user();

        $booking = Booking::create([
            'kode_booking' => 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
            'user_id' => $user->id,
            'konselor_id' => $this->konselorId,
            'nama_mahasiswa' => $user->name,
            'nim' => $user->nim,
            'prodi' => $user->prodi,
            'nomor_hp' => $user->nomor_hp,
            'email' => $user->email,
            'tanggal' => $this->tanggal,
            'jam_sesi' => $this->jamSesi,
            'deskripsi_masalah' => $this->deskripsiMasalah,
            'status' => 'menunggu',
        ]);

        $this->kodeBooking = $booking->kode_booking;
        $this->bookingBerhasil = true;
    }

    public function render()
    {
        $konselors = Konselor::where('status_aktif', true)->get();
        return view('livewire.mahasiswa.booking-form', compact('konselors'));
    }
}
