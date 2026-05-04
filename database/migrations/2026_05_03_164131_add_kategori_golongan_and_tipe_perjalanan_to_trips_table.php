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
            $table->string('kategori_golongan')->nullable()->after('golongan');
            $table->enum('tipe_perjalanan', ['luar_kota', 'dalam_kota'])->default('luar_kota')->after('tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('kategori_golongan');
            $table->dropColumn('tipe_perjalanan');
        });
    }
};