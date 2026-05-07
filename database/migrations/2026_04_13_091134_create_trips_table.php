<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['dalam_negeri', 'luar_negeri']);
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_keberangkatan');
            $table->string('nama');
            $table->string('nip');
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('jabatan');
            $table->string('eselon')->nullable()->after('jabatan'); // <-- TAMBAHKAN INI
            $table->string('golongan_luar_negeri')->nullable()->after('eselon');
            $table->text('maksud_perjalanan');
            $table->enum('jenis_angkutan', ['darat', 'udara', 'laut'])->default('udara');
            $table->string('tempat_keberangkatan');
            $table->string('tujuan');
            $table->integer('lama_hari');
            $table->date('tanggal_kembali');
            $table->decimal('uang_harian_per_hari', 15, 2);
            $table->decimal('total_uang_harian', 15, 2);
            $table->decimal('uang_representasi_per_hari', 15, 2)->default(0);
            $table->decimal('total_uang_representasi', 15, 2)->default(0);
            $table->decimal('biaya_transport_berangkat', 15, 2)->default(0);
            $table->decimal('biaya_taxi_jakarta', 15, 2)->default(0);
            $table->string('jenis_taxi_jakarta')->nullable();
            $table->decimal('biaya_transport_pulang', 15, 2)->default(0);
            $table->decimal('biaya_taxi_tujuan', 15, 2)->default(0);
            $table->decimal('biaya_dalam_kota', 15, 2)->default(0);
            $table->decimal('biaya_transport_sekitar_jakarta', 15, 2)->default(0);
            $table->decimal('biaya_hotel', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2);
            $table->string('mata_uang')->default('IDR');
            $table->string('file_pdf')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};