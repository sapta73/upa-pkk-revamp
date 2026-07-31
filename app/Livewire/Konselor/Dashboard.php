<?php

namespace App\Livewire\Konselor;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\BimbinganKonseling\Models\Booking;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\Konselor;

#[Layout('layouts.livewire')]
class Dashboard extends Component
{
    use WithPagination;

    public $konselor;
    public $tab = 'menunggu';
    public $catatan = [];
    public $linkMeeting = [];

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

    /**
     * Mencari data konselor berdasarkan akun login.
     */
    protected function cariKonselor()
    {
        $user = auth()->user();

        // Prioritas: cocokkan via user_id
        $konselor = Konselor::where('user_id', $user->id)->first();

        // Fallback: cocokkan via email
        if (!$konselor && $user->email) {
            $konselor = Konselor::where('email', $user->email)->first();
        }

        // Fallback terakhir: cocokkan via nama
        if (!$konselor) {
            $konselor = Konselor::where('nama', $user->name)->first();
        }

        return $konselor;
    }

    public function updatedTab()
    {
        $this->resetPage();
    }

    /**
     * Ubah status booking (Setuju / Tolak / Selesai).
     */
    public function ubahStatus($id, $status)
    {
        $booking = $this->bookingMilik($id);

        $statusValid = ['disetujui', 'ditolak', 'selesai', 'dibatalkan'];
        abort_unless(in_array($status, $statusValid), 422);

        $booking->update([
            'status' => $status,
            'catatan_konselor' => $this->catatan[$id] ?? $booking->catatan_konselor,
            'link_meeting' => $this->linkMeeting[$id] ?? $booking->link_meeting,
        ]);

        session()->flash('sukses', "Status booking {$booking->kode_booking} berhasil diubah menjadi " . $this->labelStatus($status) . ".");
    }

    /**
     * Booking yang hanya milik konselor yang sedang login.
     */
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
            default => 'Menunggu',
        };
    }

    public function render()
    {
        $jadwals = Jadwal::where('konselor_id', $this->konselor->id)
            ->where('status_aktif', true)
            ->get();

        $bookings = Booking::with('konselor')
            ->where('konselor_id', $this->konselor->id)
            ->when($this->tab === 'menunggu', fn($q) => $q->where('status', 'menunggu'))
            ->when($this->tab === 'aktif', fn($q) => $q->whereIn('status', ['disetujui']))
            ->when($this->tab === 'selesai', fn($q) => $q->whereIn('status', ['selesai', 'ditolak', 'dibatalkan']))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statistik = [
            'menunggu' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'menunggu')->count(),
            'disetujui' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'disetujui')->count(),
            'selesai' => Booking::where('konselor_id', $this->konselor->id)->where('status', 'selesai')->count(),
        ];

        return view('livewire.konselor.dashboard', compact('jadwals', 'bookings', 'statistik'));
    }
}
