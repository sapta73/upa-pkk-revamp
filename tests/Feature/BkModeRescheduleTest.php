<?php

namespace Tests\Feature;

use App\Livewire\Konselor\Dashboard;
use App\Livewire\Mahasiswa\BookingForm;
use App\Livewire\Mahasiswa\MyBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\BimbinganKonseling\Models\Booking;
use Modules\BimbinganKonseling\Models\Jadwal;
use Modules\BimbinganKonseling\Models\Konselor;
use Modules\BimbinganKonseling\Models\PermintaanReschedule;
use Tests\TestCase;

class BkModeRescheduleTest extends TestCase
{
    use RefreshDatabase;

    private function buatMahasiswa(): User
    {
        return User::factory()->create([
            'role' => 'mahasiswa',
            'nim' => '202600030',
            'prodi' => 'Sistem Informasi',
            'nomor_hp' => '081234567890',
        ]);
    }

    private function buatKonselor(): array
    {
        $pengguna = User::factory()->create([
            'role' => 'konselor',
            'nomor_hp' => '081200000021',
        ]);

        $konselor = Konselor::create([
            'id_konselor' => '990020',
            'user_id' => $pengguna->id,
            'nama' => 'Konselor Mode',
            'spesialisasi' => 'Karir',
            'nomor_hp' => '081200000021',
            'status_aktif' => true,
        ]);

        return [$pengguna, $konselor];
    }

    private function buatJadwal(Konselor $konselor, string $hari, string $mode = 'hybrid'): Jadwal
    {
        return Jadwal::create([
            'konselor_id' => $konselor->id,
            'hari' => $hari,
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'kuota' => 4,
            'status_aktif' => true,
            'mode' => $mode,
            'lokasi' => 'Ruang BK UPA PKK',
            'platform' => 'Zoom',
        ]);
    }

    public function test_booking_online_menyimpan_mode_dan_tanpa_lokasi(): void
    {
        [$penggunaKonselor, $konselor] = $this->buatKonselor();
        $mahasiswa = $this->buatMahasiswa();
        $jadwal = $this->buatJadwal($konselor, 'senin');
        $tanggal = Carbon::now()->next(Carbon::MONDAY)->toDateString();

        $this->actingAs($mahasiswa);

        Livewire::test(BookingForm::class, ['id' => $konselor->id])
            ->call('pilihTanggal', $tanggal)
            ->call('pilihJadwal', $jadwal->id)
            ->set('mode', 'online')
            ->set('deskripsiMasalah', 'Butuh bimbingan karier.')
            ->call('booking')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('bookings', [
            'user_id' => $mahasiswa->id,
            'konselor_id' => $konselor->id,
            'mode' => 'online',
            'lokasi' => null,
            'status' => 'menunggu',
        ]);
    }

    public function test_booking_offline_menyimpan_lokasi_jadwal(): void
    {
        [$penggunaKonselor, $konselor] = $this->buatKonselor();
        $mahasiswa = $this->buatMahasiswa();
        $jadwal = $this->buatJadwal($konselor, 'senin');
        $tanggal = Carbon::now()->next(Carbon::MONDAY)->toDateString();

        $this->actingAs($mahasiswa);

        Livewire::test(BookingForm::class, ['id' => $konselor->id])
            ->call('pilihTanggal', $tanggal)
            ->call('pilihJadwal', $jadwal->id)
            ->set('mode', 'offline')
            ->set('deskripsiMasalah', 'Butuh bimbingan karier.')
            ->call('booking')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('bookings', [
            'user_id' => $mahasiswa->id,
            'mode' => 'offline',
            'lokasi' => 'Ruang BK UPA PKK',
        ]);
    }

    public function test_mahasiswa_bisa_mengajukan_reschedule(): void
    {
        [$penggunaKonselor, $konselor] = $this->buatKonselor();
        $mahasiswa = $this->buatMahasiswa();
        $jadwalBaru = $this->buatJadwal($konselor, 'selasa');
        $tanggalBaru = Carbon::now()->next(Carbon::TUESDAY)->toDateString();

        $booking = Booking::create([
            'kode_booking' => 'BK-TEST-0001',
            'user_id' => $mahasiswa->id,
            'konselor_id' => $konselor->id,
            'nama_mahasiswa' => $mahasiswa->name,
            'nim' => $mahasiswa->nim,
            'prodi' => $mahasiswa->prodi,
            'nomor_hp' => $mahasiswa->nomor_hp,
            'email' => $mahasiswa->email,
            'tanggal' => Carbon::now()->next(Carbon::MONDAY)->toDateString(),
            'jam_sesi' => '09:00',
            'mode' => 'online',
            'deskripsi_masalah' => 'Konsultasi karier',
            'status' => 'disetujui',
        ]);

        $this->actingAs($mahasiswa);

        Livewire::test(MyBooking::class)
            ->call('bukaReschedule', $booking->id)
            ->call('pilihTanggalReschedule', $tanggalBaru)
            ->call('pilihJadwalReschedule', $jadwalBaru->id)
            ->set('alasanReschedule', 'Ada benturan jadwal.')
            ->call('kirimReschedule')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('permintaan_reschedules', [
            'booking_id' => $booking->id,
            'jadwal_id' => $jadwalBaru->id,
            'status' => 'menunggu',
        ]);
    }

    public function test_konselor_bisa_menyetujui_reschedule(): void
    {
        [$penggunaKonselor, $konselor] = $this->buatKonselor();
        $mahasiswa = $this->buatMahasiswa();
        $jadwalBaru = $this->buatJadwal($konselor, 'selasa');
        $tanggalBaru = Carbon::now()->next(Carbon::TUESDAY)->toDateString();

        $booking = Booking::create([
            'kode_booking' => 'BK-TEST-0002',
            'user_id' => $mahasiswa->id,
            'konselor_id' => $konselor->id,
            'nama_mahasiswa' => $mahasiswa->name,
            'nim' => $mahasiswa->nim,
            'prodi' => $mahasiswa->prodi,
            'nomor_hp' => $mahasiswa->nomor_hp,
            'email' => $mahasiswa->email,
            'tanggal' => Carbon::now()->next(Carbon::MONDAY)->toDateString(),
            'jam_sesi' => '09:00',
            'mode' => 'online',
            'deskripsi_masalah' => 'Konsultasi karier',
            'status' => 'disetujui',
        ]);

        $permintaan = PermintaanReschedule::create([
            'booking_id' => $booking->id,
            'user_id' => $mahasiswa->id,
            'jadwal_id' => $jadwalBaru->id,
            'tanggal_baru' => $tanggalBaru,
            'jam_baru' => '09:00',
            'alasan' => 'Ada benturan jadwal.',
            'status' => 'menunggu',
        ]);

        $this->actingAs($penggunaKonselor);

        Livewire::test(Dashboard::class)
            ->call('setujuiReschedule', $permintaan->id)
            ->assertHasNoErrors();

        $booking->refresh();
        $permintaan->refresh();

        $this->assertSame('disetujui', $permintaan->status);
        $this->assertSame($tanggalBaru, $booking->tanggal->toDateString());
        $this->assertSame('09:00', substr($booking->jam_sesi, 0, 5));
        $this->assertSame('online', $booking->mode);
    }

    public function test_konselor_bisa_menandai_booking_terlewat(): void
    {
        [$penggunaKonselor, $konselor] = $this->buatKonselor();
        $mahasiswa = $this->buatMahasiswa();

        $booking = Booking::create([
            'kode_booking' => 'BK-TEST-0003',
            'user_id' => $mahasiswa->id,
            'konselor_id' => $konselor->id,
            'nama_mahasiswa' => $mahasiswa->name,
            'nim' => $mahasiswa->nim,
            'prodi' => $mahasiswa->prodi,
            'nomor_hp' => $mahasiswa->nomor_hp,
            'email' => $mahasiswa->email,
            'tanggal' => Carbon::now()->next(Carbon::MONDAY)->toDateString(),
            'jam_sesi' => '09:00',
            'mode' => 'online',
            'deskripsi_masalah' => 'Konsultasi karier',
            'status' => 'disetujui',
        ]);

        $this->actingAs($penggunaKonselor);

        Livewire::test(Dashboard::class)
            ->call('tandaiTerlewat', $booking->id)
            ->assertHasNoErrors();

        $this->assertSame('terlewat', $booking->fresh()->status);
    }

    public function test_dosen_tidak_bisa_membuka_halaman_booking_mahasiswa(): void
    {
        $dosen = User::factory()->create([
            'role' => 'dosen',
            'nip' => '198001012005011002',
            'unit' => 'Teknologi Informasi',
        ]);

        $this->actingAs($dosen)->get('/mahasiswa/my-booking')->assertForbidden();
    }
}
