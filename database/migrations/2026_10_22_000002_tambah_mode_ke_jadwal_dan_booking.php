<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->string('mode')->default('offline')->after('konselor_id');
            $table->string('lokasi')->nullable()->after('mode');
            $table->string('platform')->nullable()->after('lokasi');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('mode')->nullable()->after('jam_sesi');
            $table->string('lokasi')->nullable()->after('mode');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE bookings MODIFY status VARCHAR(20) NOT NULL DEFAULT 'menunggu'");
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['mode', 'lokasi']);
        });

        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn(['mode', 'lokasi', 'platform']);
        });
    }
};
