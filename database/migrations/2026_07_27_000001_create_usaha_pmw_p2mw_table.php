<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel usaha_pmw_p2mw untuk menyimpan data usaha
     * dari program PMW (Program Mahasiswa Wirausaha) dan P2MW
     */
    public function up(): void
    {
        Schema::create('usaha_pmw_p2mw', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('nama_pemilik');
            $table->string('nim')->nullable();
            $table->enum('program', ['pmw', 'p2mw'])->comment('PMW atau P2MW');
            $table->string('jenis_usaha')->nullable();
            $table->year('tahun_kegiatan')->nullable();
            $table->decimal('modal_dana', 15, 2)->nullable()->comment('Modal/dana yang diterima');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable()->comment('Foto usaha');
            $table->string('sk_pendanaan')->nullable()->comment('File SK Pendanaan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usaha_pmw_p2mw');
    }
};
