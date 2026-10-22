<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TesDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_admin_diarahkan_ke_panel_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin');
    }

    public function test_konselor_diarahkan_ke_dashboard_konselor(): void
    {
        $konselor = User::factory()->create(['role' => 'konselor']);

        $this->actingAs($konselor)->get('/dashboard')->assertRedirect('/konselor/dashboard');
    }

    public function test_mahasiswa_diarahkan_ke_my_booking(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($mahasiswa)->get('/dashboard')->assertRedirect('/mahasiswa/my-booking');
    }
}
