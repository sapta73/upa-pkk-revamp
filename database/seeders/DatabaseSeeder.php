<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $admin = User::create([
            'name' => 'Admin UPA PKK',
            'email' => 'admin@upa-pkk.ubb.ac.id',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
        $admin->email_verified_at = now();
        $admin->save();

        $this->call([
            LowonganKerjaSeeder::class,
        ]);
    }
}
