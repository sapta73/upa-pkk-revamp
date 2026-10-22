<?php

namespace App\Livewire\Konselor;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\BimbinganKonseling\Models\Booking;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\Konselor;
use Modules\BimbinganKonseling\Models\PermintaanReschedule;

#[Layout('layouts.livewire')]
class Dashboard extends Component
{
    use WithPagination;

    public $konselor;
    public $tab = 'menunggu';
    public $catatan = [];
    public $linkMeeting = [];
    public $catatanReschedule = [];

    protected $rules = [
        'catatan.*' => 'nullable|string',
        'linkMeeting.*' => 'nullable|url',
    ];

    public function mount()
    {
        $this->konselor = $this->cariKonselor();

        if (!$this->konselor) {
            abort(403, 'Akun Anda belum terhubung dengan data konselor. Hubungi admin.');
        }
    }

    protected function cariKonselor()
    {
        return Konselor::where('user_id', auth()->id())->first();
    }

    public function updatedTab()
    {
        $this->resetPage();
    }

    public function ubahStatus($id, $status)
    {
        $booking = $this->bookingMilik($id);

        $statusValid = ['disetujui', 'ditolak', 'selesai', 'dibatalkan', 'terlewat'];
        abort_unless(in_array($status, $statusValid), 422);

        $booking->update([
            'status' => $status,
            'catatan_konselor' => $this->catatan[$id] ?? $booking->catatan_konselor,
            'link_meeting' => $this->linkMeeting[$id] ?? $booking->link_meeting,
        ]);

        session()->flash('sukses', "Status booking {$booking->kode_booking} berhasil diubah menjadi " . $this->labelStatus($status) . '.');
    }

    public function tandaiTerlewat($id)
    {
        $booking = $this->bookingMilik($id);
        $booking->update(['status' => 'terlewat']);
        session()->flash('sukses', "Booking {$booking->kode_booking} ditandai terlewat.");
    }

    public function setujuiReschedule($id)
    {
        $permintaan = PermintaanReschedule::with(['booking', 'jadwal'])
            ->whereHas('booking', fn ($query) => $query->where('konselor_id', $this->konselor->id))
            ->where('status', 'menunggu')
            ->findOrFail($id);

        $booking = $permintaan->booking;
        $jadwal = $permintaan->jadwal;

        if (!$jadwal) {
            session()->flash('gagal', 'Jadwal baru tidak ditemukan.');

            return;
        }

        $terisi = Booking::where('konselor_id', $this->konselor->id)
            ->where('tanggal', $permintaan->tanggal_baru)
            ->where('jam_sesi', substr($jadwal->jam_mulai, 0, 5))
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where('id', '!=', $booking->id)
            ->count();

        if ($jadwal->kuota > 0 && $terisi >= $jadwal->kuota) {
            session()->flash('gagal', 'Kuota jadwal baru sudah penuh.');

            return;
        }

        DB::transaction(function () use ($booking, $permintaan, $jadwal) {
            $mode = $jadwal->mode === 'hybrid' ? ($booking->mode ?: 'online') : $jadwal->mode;

            $booking->update([
                'tanggal' => $permintaan->tanggal_baru->toDateString(),
                'jam_sesi' => substr($jadwal->jam_mulai, 0, 5),
                'mode' => $mode,
                'lokasi' => $mode === 'offline' ? $jadwal->lokasi : null,
                'status' => 'disetujui',
            ]);

            $permintaan->update(['status' => 'disetujui']);
        });

        session()->flash('sukses', 'Permintaan reschedule disetujui.');
    }

    public function tolakReschedule($id)
    {
        $permintaan = PermintaanReschedule::whereHas('booking', fn ($query) => $query->where('konselor_id', $this->konselor->id))
            ->where('status', 'menunggu')
            ->findOrFail($id);

        $permintaan->update([
            'status' => 'ditolak',
            'catatan_konselor' => $this->catatanReschedule[$id] ?? null,
        ]);

        session()->flash('sukses', 'Permintaan reschedule ditolak.');
    }

    protected function bookingMilik($id)
    {
        return Booking::where('id', $id)
            ->where('konselor_id', $this->konselor->id)
            ->firstOrFail();
    }

    protected function labelStatus($status)
    {
        return match ($status) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            'terlewat' => 'Terlewat',
            default => 'Menunggu',
        };
    }

    public function render()
    {
        $jadwals = Jadwal::where('konselor_id', $this->konselor->id)
            ->where('status_aktif', true)
            ->get();

        $permintaanReschedule = collect();

        if ($this->tab === 'reschedule') {
            $bookings = Booking::whereRaw('1 = 0')->paginate(10);
            $permintaanReschedule = PermintaanReschedule::with(['booking', 'user', 'jadwal'])
                ->whereHas('booking', fn ($query) => $query->where('konselor_id', $this->konselor->id))
                ->where('status', 'menunggu')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $bookings = Booking::with('konselor')
                ->where('konselor_id', $this->konselor->id)
                ->when($this->tab === 'menunggu', fn ($query) => $query->where('status', 'menunggu'))
                ->when($this->tab === 'aktif', fn ($query) => $query->whereIn('status', ['disetujui', 'terlewat']))
                ->when($this->tab === 'selesai', fn ($query) => $query->whereIn('status', ['selesai', 'ditolak', 'dibatalkan']))
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $statistik = [
            'menunggu' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'menunggu')->count(),
            'disetujui' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'disetujui')->count(),
            'selesai' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'selesai')->count(),
            'terlewat' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'terlewat')->count(),
            'reschedule' => PermintaanReschedule::whereHas('booking', fn ($query) => $query->where('konselor_id', $this->konselor->id))->where('status', 'menunggu')->count(),
        ];

        return view('livewire.konselor.dashboard', compact('jadwals', 'bookings', 'statistik', 'permintaanReschedule'));
    }
}
