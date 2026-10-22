<?php

namespace App\Livewire\Mahasiswa;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\BimbinganKonseling\Models\Booking;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\PermintaanReschedule;

#[Layout('layouts.livewire')]
class MyBooking extends Component
{
    public $tab = 'aktif';

    public $bookingReschedule;
    public $tanggalReschedule;
    public $jadwalRescheduleTersedia = [];
    public $jadwalRescheduleId;
    public $alasanReschedule;

    public function batalkan($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $booking->update(['status' => 'dibatalkan']);
    }

    public function bukaReschedule($id)
    {
        $this->bookingReschedule = Booking::with('konselor')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['disetujui', 'terlewat'])
            ->firstOrFail();

        $this->tanggalReschedule = null;
        $this->jadwalRescheduleTersedia = [];
        $this->jadwalRescheduleId = null;
        $this->alasanReschedule = null;
    }

    public function tutupReschedule()
    {
        $this->bookingReschedule = null;
        $this->tanggalReschedule = null;
        $this->jadwalRescheduleTersedia = [];
        $this->jadwalRescheduleId = null;
        $this->alasanReschedule = null;
    }

    public function pilihTanggalReschedule($nilai)
    {
        $this->tanggalReschedule = $nilai;
        $this->jadwalRescheduleTersedia = [];
        $this->jadwalRescheduleId = null;

        if (!$this->tanggalReschedule || !$this->bookingReschedule) {
            return;
        }

        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = strtolower($namaHari[Carbon::parse($this->tanggalReschedule)->dayOfWeek]);

        $this->jadwalRescheduleTersedia = Jadwal::where('konselor_id', $this->bookingReschedule->konselor_id)
            ->where('status_aktif', true)
            ->where('hari', $hari)
            ->get()
            ->map(function ($jadwal) {
                $terisi = Booking::where('konselor_id', $this->bookingReschedule->konselor_id)
                    ->where('tanggal', $this->tanggalReschedule)
                    ->where('jam_sesi', substr($jadwal->jam_mulai, 0, 5))
                    ->whereIn('status', ['menunggu', 'disetujui'])
                    ->count();

                $jadwal->sisa_kuota = max(0, (int) $jadwal->kuota - $terisi);

                return $jadwal;
            })
            ->filter(fn ($jadwal) => $jadwal->sisa_kuota > 0)
            ->values()
            ->all();
    }

    public function pilihJadwalReschedule($nilai)
    {
        $this->jadwalRescheduleId = $nilai ?: null;
    }

    public function kirimReschedule()
    {
        $this->validate([
            'tanggalReschedule' => 'required|date|after:today',
            'jadwalRescheduleId' => 'required',
            'alasanReschedule' => 'required|string|min:5|max:1000',
        ]);

        $booking = $this->bookingReschedule;

        abort_unless($booking && $booking->user_id === auth()->id(), 403);

        $jadwal = Jadwal::findOrFail($this->jadwalRescheduleId);

        abort_unless($jadwal->konselor_id === $booking->konselor_id, 422);

        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = strtolower($namaHari[Carbon::parse($this->tanggalReschedule)->dayOfWeek]);

        if ($jadwal->hari !== $hari) {
            $this->addError('jadwalRescheduleId', 'Jadwal tidak tersedia di tanggal yang dipilih.');

            return;
        }

        $pending = PermintaanReschedule::where('booking_id', $booking->id)
            ->where('status', 'menunggu')
            ->exists();

        if ($pending) {
            $this->addError('alasanReschedule', 'Sudah ada permintaan reschedule yang menunggu persetujuan.');

            return;
        }

        PermintaanReschedule::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'jadwal_id' => $jadwal->id,
            'tanggal_baru' => $this->tanggalReschedule,
            'jam_baru' => substr($jadwal->jam_mulai, 0, 5),
            'alasan' => $this->alasanReschedule,
            'status' => 'menunggu',
        ]);

        $this->tutupReschedule();
        session()->flash('sukses', 'Permintaan reschedule berhasil dikirim. Menunggu persetujuan konselor.');
    }

    public function render()
    {
        $bookings = Booking::with(['konselor', 'permintaanReschedule'])
            ->where('user_id', auth()->id())
            ->when($this->tab == 'aktif', fn ($q) => $q->whereIn('status', ['menunggu', 'disetujui', 'terlewat']))
            ->when($this->tab == 'riwayat', fn ($q) => $q->whereIn('status', ['selesai', 'dibatalkan', 'ditolak']))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.mahasiswa.my-booking', compact('bookings'));
    }
}
