<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\BimbinganKonseling\Models\Konselor;
use Tests\TestCase;

class TesProfilTest extends TestCase
{
    use RefreshDatabase;

    private function buatMahasiswa(array $atribut = []): User
    {
        return User::factory()->create(array_merge([
            'role' => 'mahasiswa',
            'nim' => '202600001',
            'prodi' => 'Sistem Informasi',
            'nomor_hp' => '081234567890',
        ], $atribut));
    }

    private function buatKonselor(array $atribut = []): User
    {
        return User::factory()->create(array_merge([
            'role' => 'konselor',
            'nomor_hp' => '081298765432',
        ], $atribut));
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/profil')->assertRedirect('/login');
    }

    public function test_semua_role_bisa_membuka_halaman_profil(): void
    {
        $mahasiswa = $this->buatMahasiswa();
        $konselor = $this->buatKonselor();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($mahasiswa)->get('/profil')->assertOk();
        $this->actingAs($konselor)->get('/profil')->assertOk();
        $this->actingAs($admin)->get('/profil')->assertOk();
    }

    public function test_mahasiswa_bisa_memperbarui_data_diri(): void
    {
        $mahasiswa = $this->buatMahasiswa();

        $response = $this->actingAs($mahasiswa)->patch('/profil', [
            'name' => 'Mahasiswa Baru',
            'email' => 'mahasiswa.baru@example.com',
            'nim' => '202600002',
            'prodi' => 'Teknik Informatika',
            'nomor_hp' => '081200000001',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profil');

        $mahasiswa->refresh();

        $this->assertSame('Mahasiswa Baru', $mahasiswa->name);
        $this->assertSame('mahasiswa.baru@example.com', $mahasiswa->email);
        $this->assertSame('202600002', $mahasiswa->nim);
        $this->assertSame('Teknik Informatika', $mahasiswa->prodi);
        $this->assertSame('081200000001', $mahasiswa->nomor_hp);
        $this->assertNull($mahasiswa->email_verified_at);
    }

    public function test_konselor_bisa_memperbarui_data_dan_tersinkron_ke_data_publik(): void
    {
        $konselor = $this->buatKonselor();

        $dataKonselor = Konselor::create([
            'id_konselor' => '990010',
            'user_id' => $konselor->id,
            'nama' => 'Konselor Lama',
            'spesialisasi' => 'Karir',
            'email' => $konselor->email,
            'nomor_hp' => $konselor->nomor_hp,
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($konselor)->patch('/profil', [
            'name' => 'Konselor Baru',
            'email' => 'konselor.baru@example.com',
            'nomor_hp' => '081200000002',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profil');

        $this->assertSame('Konselor Baru', $konselor->fresh()->name);
        $this->assertSame('konselor.baru@example.com', $konselor->fresh()->email);
        $this->assertSame('081200000002', $konselor->fresh()->nomor_hp);

        $dataKonselor->refresh();

        $this->assertSame('Konselor Baru', $dataKonselor->nama);
        $this->assertSame('konselor.baru@example.com', $dataKonselor->email);
        $this->assertSame('081200000002', $dataKonselor->nomor_hp);
    }

    public function test_admin_bisa_memperbarui_nama_dan_email(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch('/profil', [
            'name' => 'Admin Baru',
            'email' => 'admin.baru@example.com',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profil');

        $this->assertSame('Admin Baru', $admin->fresh()->name);
        $this->assertSame('admin.baru@example.com', $admin->fresh()->email);
    }

    public function test_nim_dan_email_duplikat_ditolak(): void
    {
        $pertama = $this->buatMahasiswa(['email' => 'pertama@example.com', 'nim' => '202600010']);
        $kedua = $this->buatMahasiswa(['email' => 'kedua@example.com', 'nim' => '202600011']);

        $response = $this->actingAs($kedua)->patch('/profil', [
            'name' => 'Mahasiswa Kedua',
            'email' => 'pertama@example.com',
            'nim' => '202600010',
            'prodi' => 'Sistem Informasi',
            'nomor_hp' => '081200000003',
        ]);

        $response->assertSessionHasErrors(['email', 'nim']);
        $this->assertSame('202600011', $kedua->fresh()->nim);
        $this->assertSame('kedua@example.com', $kedua->fresh()->email);
    }

    public function test_mahasiswa_bisa_menghapus_akun(): void
    {
        $mahasiswa = $this->buatMahasiswa();

        $response = $this->actingAs($mahasiswa)->delete('/profil', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/');
        $this->assertGuest();
        $this->assertNull($mahasiswa->fresh());
    }

    public function test_konselor_tidak_bisa_menghapus_akun(): void
    {
        $konselor = $this->buatKonselor();

        $this->actingAs($konselor)->delete('/profil', [
            'password' => 'password',
        ])->assertForbidden();

        $this->assertNotNull($konselor->fresh());
    }

    public function test_admin_tidak_bisa_menghapus_akun(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->delete('/profil', [
            'password' => 'password',
        ])->assertForbidden();

        $this->assertNotNull($admin->fresh());
    }

    public function test_mahasiswa_belum_verifikasi_tidak_bisa_membuka_halaman_booking(): void
    {
        config(['upa.verifikasi_email' => true]);
        $mahasiswa = $this->buatMahasiswa(['email_verified_at' => null]);

        $this->actingAs($mahasiswa)->get('/mahasiswa/my-booking')->assertRedirect('/verify-email');
    }

    public function test_konselor_belum_verifikasi_tidak_bisa_membuka_dashboard(): void
    {
        config(['upa.verifikasi_email' => true]);
        $konselor = $this->buatKonselor(['email_verified_at' => null]);

        $this->actingAs($konselor)->get('/konselor/dashboard')->assertRedirect('/verify-email');
    }

    public function test_user_belum_verifikasi_tetap_bisa_membuka_profil(): void
    {
        $mahasiswa = $this->buatMahasiswa(['email_verified_at' => null]);

        $this->actingAs($mahasiswa)->get('/profil')->assertOk();
    }
}
