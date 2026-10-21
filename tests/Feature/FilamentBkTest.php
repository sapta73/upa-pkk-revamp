<?php

namespace Tests\Feature;

use App\Filament\Resources\BkResource\Pages\CreateKonselor;
use App\Filament\Resources\BkResource\Pages\EditKonselor;
use App\Filament\Resources\JadwalResource\Pages\CreateJadwal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Modules\BimbinganKonseling\Models\Konselor;
use Tests\TestCase;

class FilamentBkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_membuat_konselor_dengan_akun_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Livewire::test(CreateKonselor::class)
            ->fillForm([
                'id_konselor' => '990001',
                'nama' => 'Konselor Uji',
                'spesialisasi' => 'Karir',
                'email' => 'konselor.uji@example.com',
                'password_akun' => 'rahasia123',
                'status_aktif' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $pengguna = User::where('email', 'konselor.uji@example.com')->first();

        $this->assertNotNull($pengguna);
        $this->assertSame('konselor', $pengguna->role);
        $this->assertDatabaseHas('konselors', [
            'id_konselor' => '990001',
            'user_id' => $pengguna->id,
        ]);
    }

    public function test_admin_membuat_jadwal_konselor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $konselor = Konselor::create([
            'id_konselor' => '990002',
            'nama' => 'Konselor Jadwal',
            'spesialisasi' => 'Psikologi',
            'status_aktif' => true,
        ]);

        Livewire::test(CreateJadwal::class)
            ->fillForm([
                'konselor_id' => $konselor->id,
                'hari' => 'senin',
                'jam_mulai' => '09:00',
                'jam_selesai' => '12:00',
                'kuota' => 4,
                'status_aktif' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('jadwals', [
            'konselor_id' => $konselor->id,
            'hari' => 'senin',
            'kuota' => 4,
        ]);
    }

    public function test_admin_menautkan_akun_dan_mereset_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $konselor = Konselor::create([
            'id_konselor' => '990003',
            'nama' => 'Konselor Taut',
            'spesialisasi' => 'Karir',
            'status_aktif' => true,
        ]);

        $akun = User::factory()->create(['role' => 'konselor']);

        Livewire::test(EditKonselor::class, ['record' => $konselor->getRouteKey()])
            ->fillForm([
                'id_konselor' => '990003',
                'nama' => 'Konselor Taut',
                'spesialisasi' => 'Karir',
                'user_id' => $akun->id,
                'password_akun' => 'passwordbaru123',
                'status_aktif' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame($akun->id, $konselor->fresh()->user_id);
        $this->assertTrue(Hash::check('passwordbaru123', $akun->fresh()->password));
    }
}
