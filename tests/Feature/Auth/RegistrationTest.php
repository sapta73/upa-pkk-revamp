<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        config(['upa.verifikasi_email' => true]);
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'nim' => '202699999',
            'prodi' => 'Sistem Informasi',
            'nomor_hp' => '081234567890',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice', absolute: false));

        $pengguna = User::where('email', 'test@example.com')->first();

        $this->assertNotNull($pengguna);
        $this->assertNull($pengguna->email_verified_at);
        Notification::assertSentTo($pengguna, VerifyEmail::class);
    }
}
