<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            // Transportasi detail
            $table->string('transportasi_luar_kota_type')->nullable()->after('biaya_transport'); // Pesawat, Kereta, Bus, Kapal, BBM
            $table->decimal('transportasi_luar_kota_biaya', 15, 2)->nullable()->after('transportasi_luar_kota_type');

            // Taxi Jakarta
            $table->string('taxi_jakarta_type')->nullable()->after('transportasi_luar_kota_biaya'); // "1 Kali Jalan" atau "PP"
            $table->decimal('taxi_jakarta_biaya', 15, 2)->default(0)->after('taxi_jakarta_type');

            // Taxi Tujuan (otomatis dari bandara/stasiun ke lokasi)
            $table->string('taxi_tujuan_provinsi')->nullable()->after('taxi_jakarta_biaya');
            $table->decimal('taxi_tujuan_biaya', 15, 2)->default(0)->after('taxi_tujuan_provinsi');

            // Transportasi dalam kota Jakarta
            $table->boolean('gunakan_transport_dalam_kota')->default(false)->after('taxi_tujuan_biaya');
            $table->decimal('transport_dalam_kota_biaya', 15, 2)->default(0)->after('gunakan_transport_dalam_kota');

            // Uang Representasi
            $table->string('eselon_jabatan')->nullable()->after('transport_dalam_kota_biaya'); // Eselon I, Eselon II, dll
            $table->decimal('uang_representasi', 15, 2)->default(0)->after('eselon_jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn([
                'transportasi_luar_kota_type',
                'transportasi_luar_kota_biaya',
                'taxi_jakarta_type',
                'taxi_jakarta_biaya',
                'taxi_tujuan_provinsi',
                'taxi_tujuan_biaya',
                'gunakan_transport_dalam_kota',
                'transport_dalam_kota_biaya',
                'eselon_jabatan',
                'uang_representasi',
            ]);
        });
    }
};
