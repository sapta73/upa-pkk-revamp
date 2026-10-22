<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp');
            $table->string('instansi')->nullable();
            $table->string('status')->default('menunggu');
            $table->string('status_bayar')->default('gratis');
            $table->string('bukti_bayar')->nullable();
            $table->string('status_hadir')->default('belum');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['kegiatan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kegiatan');
    }
};
