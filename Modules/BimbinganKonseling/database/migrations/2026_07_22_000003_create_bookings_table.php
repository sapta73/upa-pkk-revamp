<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('konselor_id')->constrained('konselors')->cascadeOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('prodi');
            $table->string('nomor_hp');
            $table->string('email');
            $table->date('tanggal');
            $table->time('jam_sesi');
            $table->text('deskripsi_masalah')->nullable();
            $table->string('status')->default('menunggu');
            $table->string('link_meeting')->nullable();
            $table->text('catatan_konselor')->nullable();
            $table->timestamp('waktu_booking')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
