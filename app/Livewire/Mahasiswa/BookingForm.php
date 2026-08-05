<?php
namespace App\Livewire\Mahasiswa;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\BimbinganKonseling\Models\Konselor;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\Booking;

#[Layout('layouts.livewire')]
class BookingForm extends Component
{
    public $konselorId;
    public $konselor;
    public $tanggal;
    public $jadwalTersedia = [];
    public $selectedJadwal;
    public $deskripsiMasalah;
    public $step = 1;
    public $bookingBerhasil = false;
    public $kodeBooking;
    public $jamSesiTerpilih;

    protected $rules = [
        'tanggal' => 'required|date|after:today',
        'selectedJadwal' => 'required',
        'deskripsiMasalah' => 'required|min:10',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->konselorId = $id;
            $this->konselor = Konselor::with('jadwals')->findOrFail($id);
            $this->step = 2;
        }
    }

    /**
     * Nama hari Indonesia dari tanggal yang dipilih (Minggu..Sabtu).
     */
    public function namaHariTanggal(): string
    {
        if (!$this->tanggal) {
            return '';
        }

        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return $namaHari[Carbon::parse($this->tanggal)->dayOfWeek];
    }

    /**
     * Dipanggil dari wire:change pada input tanggal.
     * Menerima nilai tanggal langsung dari DOM (anti-gagal sync).
     */
    public function pilihTanggal($nilai)
    {
        $this->tanggal = $nilai;
        $this->updatedTanggal();
    }

    /**
     * Dependent selection: saat tanggal dipilih, tampilkan HANYA jadwal
     * yang hari-nya cocok dengan hari pada tanggal, beserta sisa kuota asli.
     */
    public function updatedTanggal()
    {
        $this->jadwalTersedia = collect();
        $this->selectedJadwal = null;

        if (!$this->tanggal || !$this->konselor) {
            return;
        }

        $hari = strtolower($this->namaHariTanggal());

        $this->jadwalTersedia = $this->konselor->jadwals()
            ->where('status_aktif', true)
            ->where('hari', $hari)
            ->get()
            ->map(function ($jadwal) {
                $jadwal->sisa_kuota = $this->sisaKuota($jadwal);

                return $jadwal;
            })
            ->filter(fn ($jadwal) => $jadwal->sisa_kuota > 0)
            ->values();
    }

    /**
     * Sisa kuota slot: kuota dikurangi booking aktif (menunggu/disetujui)
     * pada konselor + tanggal + jam yang sama.
     */
    protected function sisaKuota(Jadwal $jadwal): int
    {
        $terisi = Booking::where('konselor_id', $this->konselorId)
            ->where('tanggal', $this->tanggal)
            ->where('jam_sesi', substr($jadwal->jam_mulai, 0, 5))
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        return max(0, (int) $jadwal->kuota - $terisi);
    }

    public function pilihKonselor($id)
    {
        $this->konselorId = $id;
        $this->konselor = Konselor::with('jadwals')->findOrFail($id);
        $this->tanggal = null;
        $this->jadwalTersedia = collect();
        $this->selectedJadwal = null;
        $this->step = 2;
    }

    /**
     * Dipanggil dari wire:change pada dropdown jadwal.
     * Menerima nilai jadwal langsung dari DOM (anti-gagal sync).
     */
    public function pilihJadwal($nilai)
    {
        $this->selectedJadwal = $nilai ?: null;
    }

    public function booking()
    {
        $this->validate();

        $jadwal = Jadwal::findOrFail($this->selectedJadwal);
        $user = auth()->user();

        // ============ ABAC: validasi ulang di BACKEND ============
        // Jangan pernah percaya begitu saja pada input UI.

        // 1) Jadwal harus milik konselor yang sedang dibooking
        abort_unless($jadwal->konselor_id === (int) $this->konselorId, 422);

        // 2) Hari pada jadwal WAJIB cocok dengan hari pada tanggal yang dipilih
        $hari = strtolower($this->namaHariTanggal());
        if ($jadwal->hari !== $hari) {
            $this->addError('selectedJadwal', 'Jadwal yang dipilih tidak tersedia di tanggal tersebut. Silakan pilih jadwal sesuai hari yang dipilih.');

            return;
        }

        // 3) Kuota jadwal tidak boleh sudah penuh
        if ($this->sisaKuota($jadwal) <= 0) {
            $this->addError('selectedJadwal', 'Kuota jadwal ini sudah penuh. Silakan pilih jadwal lain atau tanggal lain.');

            return;
        }

        // 4) Cegah booking dobel: user yang sama di slot yang sama
        $dobel = Booking::where('user_id', $user->id)
            ->where('konselor_id', $this->konselorId)
            ->where('tanggal', $this->tanggal)
            ->where('jam_sesi', substr($jadwal->jam_mulai, 0, 5))
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($dobel) {
            $this->addError('tanggal', 'Kamu sudah memiliki booking aktif di sesi ini.');

            return;
        }

        $jamSesi = substr($jadwal->jam_mulai, 0, 5);

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
            'jam_sesi' => $jamSesi,
            'deskripsi_masalah' => $this->deskripsiMasalah,
            'status' => 'menunggu',
        ]);

        $this->kodeBooking = $booking->kode_booking;
        $this->jamSesiTerpilih = $jamSesi;
        $this->bookingBerhasil = true;
    }

    public function render()
    {
        $konselors = Konselor::where('status_aktif', true)->get();
        return view('livewire.mahasiswa.booking-form', compact('konselors'));
    }
}
