<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\PendaftaranKegiatan;
use App\Models\PendaftaranProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KegiatanDanProgramTest extends TestCase
{
    use RefreshDatabase;

    private function buatKegiatan(array $atribut = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'jenis' => 'workshop',
            'judul' => 'Cooking Class UPA PKK',
            'slug' => 'cooking-class-upa-pkk',
            'deskripsi' => 'Workshop memasak untuk mahasiswa.',
            'harga' => 0,
            'tanggal_mulai' => now()->addWeek()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'kuota' => 10,
            'status_aktif' => true,
        ], $atribut));
    }

    private function buatMahasiswa(array $atribut = []): User
    {
        return User::factory()->create(array_merge([
            'role' => 'mahasiswa',
            'nim' => '202600020',
            'prodi' => 'Sistem Informasi',
            'nomor_hp' => '081234567890',
        ], $atribut));
    }

    public function test_halaman_karier_workshop_dan_seminar_bisa_dibuka(): void
    {
        $this->buatKegiatan();
        $this->buatKegiatan([
            'jenis' => 'seminar',
            'judul' => 'Pendampingan Wisuda',
            'slug' => 'pendampingan-wisuda',
            'wajib' => true,
        ]);

        $this->get('/karier')->assertOk();
        $this->get('/karier/workshop')->assertOk();
        $this->get('/karier/seminar')->assertOk();
        $this->get('/karier/workshop/cooking-class-upa-pkk')->assertOk();
        $this->get('/karier/seminar/pendampingan-wisuda')->assertOk();
    }

    public function test_tamu_harus_login_untuk_mendaftar_kegiatan(): void
    {
        $kegiatan = $this->buatKegiatan();

        $this->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), [
            'nama' => 'Tamu',
            'email' => 'tamu@example.com',
            'nomor_hp' => '081200000000',
        ])->assertRedirect('/login');
    }

    public function test_mahasiswa_bisa_mendaftar_workshop_gratis(): void
    {
        $mahasiswa = $this->buatMahasiswa();
        $kegiatan = $this->buatKegiatan();

        $response = $this->actingAs($mahasiswa)->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), [
            'nama' => $mahasiswa->name,
            'email' => $mahasiswa->email,
            'nomor_hp' => $mahasiswa->nomor_hp,
            'instansi' => $mahasiswa->prodi,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('pendaftaran_kegiatan', [
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $mahasiswa->id,
            'status_bayar' => 'gratis',
            'status_hadir' => 'belum',
        ]);
    }

    public function test_pendaftaran_ganda_ditolak(): void
    {
        $mahasiswa = $this->buatMahasiswa();
        $kegiatan = $this->buatKegiatan();

        $data = [
            'nama' => $mahasiswa->name,
            'email' => $mahasiswa->email,
            'nomor_hp' => $mahasiswa->nomor_hp,
        ];

        $this->actingAs($mahasiswa)->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), $data);
        $response = $this->actingAs($mahasiswa)->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), $data);

        $response->assertSessionHas('gagal');
        $this->assertSame(1, PendaftaranKegiatan::count());
    }

    public function test_workshop_berbayar_memerlukan_bukti_pembayaran(): void
    {
        Storage::fake('public');
        $mahasiswa = $this->buatMahasiswa();
        $kegiatan = $this->buatKegiatan(['harga' => 50000]);

        $this->actingAs($mahasiswa)->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), [
            'nama' => $mahasiswa->name,
            'email' => $mahasiswa->email,
            'nomor_hp' => $mahasiswa->nomor_hp,
        ]);

        $pendaftaran = PendaftaranKegiatan::firstOrFail();
        $this->assertSame('menunggu', $pendaftaran->status_bayar);

        $response = $this->actingAs($mahasiswa)->post(route('kegiatan.bukti', ['workshop', $kegiatan->slug]), [
            'bukti_bayar' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sukses');

        $pendaftaran->refresh();
        $this->assertNotNull($pendaftaran->bukti_bayar);
        $this->assertSame('menunggu', $pendaftaran->status_bayar);
        Storage::disk('public')->assertExists($pendaftaran->bukti_bayar);
    }

    public function test_dosen_dan_tendik_bisa_mendaftar_seminar(): void
    {
        $dosen = User::factory()->create([
            'role' => 'dosen',
            'nip' => '198001012005011001',
            'unit' => 'Teknologi Informasi',
        ]);
        $kegiatan = $this->buatKegiatan([
            'jenis' => 'seminar',
            'judul' => 'Pendampingan Wisuda',
            'slug' => 'pendampingan-wisuda',
        ]);

        $response = $this->actingAs($dosen)->post(route('kegiatan.daftar', ['seminar', $kegiatan->slug]), [
            'nama' => $dosen->name,
            'email' => $dosen->email,
            'nomor_hp' => '081200000011',
            'instansi' => $dosen->unit,
        ]);

        $response->assertSessionHas('sukses');
        $this->assertDatabaseHas('pendaftaran_kegiatan', [
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $dosen->id,
        ]);
    }

    public function test_konselor_tidak_bisa_mendaftar_kegiatan(): void
    {
        $konselor = User::factory()->create(['role' => 'konselor']);
        $kegiatan = $this->buatKegiatan();

        $this->actingAs($konselor)->post(route('kegiatan.daftar', ['workshop', $kegiatan->slug]), [
            'nama' => $konselor->name,
            'email' => $konselor->email,
            'nomor_hp' => '081200000012',
        ])->assertForbidden();
    }

    public function test_mahasiswa_bisa_mendaftar_program(): void
    {
        $mahasiswa = $this->buatMahasiswa();

        $response = $this->actingAs($mahasiswa)->post(route('wirausaha.program.store'), [
            'program' => 'pmw',
            'nama_tim' => 'Tim Kopi Senja',
            'ketua' => $mahasiswa->name,
            'anggota' => "Anggota Satu\nAnggota Dua",
            'judul_usaha' => 'Kopi Senja UBB',
            'deskripsi' => 'Kedai kopi mahasiswa di sekitar kampus.',
            'link_proposal' => 'https://example.com/proposal-pmw',
        ]);

        $response->assertRedirect(route('wirausaha.program.create'));
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('pendaftaran_program', [
            'user_id' => $mahasiswa->id,
            'program' => 'pmw',
            'status' => 'menunggu',
        ]);
    }

    public function test_pendaftaran_program_ganda_ditolak(): void
    {
        $mahasiswa = $this->buatMahasiswa();

        $data = [
            'program' => 'p2mw',
            'nama_tim' => 'Tim Inovasi',
            'ketua' => $mahasiswa->name,
            'anggota' => 'Anggota Satu',
            'judul_usaha' => 'Inovasi Kampus',
            'deskripsi' => 'Produk inovasi mahasiswa.',
            'link_proposal' => 'https://example.com/proposal-p2mw',
        ];

        $this->actingAs($mahasiswa)->post(route('wirausaha.program.store'), $data);
        $response = $this->actingAs($mahasiswa)->post(route('wirausaha.program.store'), $data);

        $response->assertSessionHas('gagal');
        $this->assertSame(1, PendaftaranProgram::count());
    }

    public function test_konselor_tidak_bisa_membuka_form_program(): void
    {
        $konselor = User::factory()->create(['role' => 'konselor']);

        $this->actingAs($konselor)->get(route('wirausaha.program.create'))->assertForbidden();
    }
}
