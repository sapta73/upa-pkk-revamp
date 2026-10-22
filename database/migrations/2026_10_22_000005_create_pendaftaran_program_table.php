<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('program');
            $table->string('nama_tim');
            $table->string('ketua');
            $table->text('anggota')->nullable();
            $table->string('judul_usaha');
            $table->text('deskripsi');
            $table->string('link_proposal');
            $table->string('status')->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'program']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_program');
    }
};
