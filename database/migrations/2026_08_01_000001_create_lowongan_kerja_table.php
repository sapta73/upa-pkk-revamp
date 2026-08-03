<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel lowongan pekerjaan yang dikelola oleh admin UPA PKK.
     */
    public function up(): void
    {
        Schema::create('lowongan_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('perusahaan');
            $table->string('posisi');
            $table->string('lokasi');
            $table->enum('tipe_pekerjaan', ['full_time', 'part_time', 'magang', 'kontrak'])
                ->default('full_time')
                ->comment('full_time, part_time, magang, kontrak');
            $table->text('deskripsi');
            $table->text('persyaratan')->nullable();
            $table->string('gaji')->nullable()->comment('Contoh: Rp 3.500.000 - Rp 5.000.000 / Negosiasi');
            $table->unsignedInteger('kuota')->nullable();
            $table->date('batas_lamaran')->nullable();
            $table->string('link_pendaftaran')->nullable();
            $table->string('kontak')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_kerja');
    }
};
