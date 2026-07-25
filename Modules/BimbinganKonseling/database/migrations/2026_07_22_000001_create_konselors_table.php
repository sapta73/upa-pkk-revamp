<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselors', function (Blueprint $table) {
            $table->id();
            $table->string('id_konselor')->unique();
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            $table->string('spesialisasi');
            $table->text('bio')->nullable();
            $table->string('foto')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselors');
    }
};
