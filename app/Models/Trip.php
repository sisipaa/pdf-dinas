<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'nomor_surat',
        'tanggal_keberangkatan',
        'nama',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
        'eselon',  // Bisa NULL untuk pegawai biasa
        'golongan_luar_negeri',
        'maksud_perjalanan',
        'jenis_angkutan',
        'tempat_keberangkatan',
        'tujuan',
        'lama_hari',
        'tanggal_kembali',
        'uang_harian_per_hari',
        'total_uang_harian',
        'uang_representasi_per_hari',
        'total_uang_representasi',
        'biaya_transport_berangkat',
        'biaya_taxi_jakarta',
        'jenis_taxi_jakarta',
        'biaya_transport_pulang',
        'biaya_taxi_tujuan',
        'biaya_dalam_kota',
        'biaya_transport_sekitar_jakarta',
        'biaya_hotel',
        'total_biaya',
        'mata_uang',
        'file_pdf',
        'status',
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'date',
        'tanggal_kembali' => 'date',
        'uang_harian_per_hari' => 'decimal:2',
        'total_uang_harian' => 'decimal:2',
        'uang_representasi_per_hari' => 'decimal:2',
        'total_uang_representasi' => 'decimal:2',
        'biaya_transport_berangkat' => 'decimal:2',
        'biaya_taxi_jakarta' => 'decimal:2',
        'biaya_transport_pulang' => 'decimal:2',
        'biaya_taxi_tujuan' => 'decimal:2',
        'biaya_dalam_kota' => 'decimal:2',
        'biaya_transport_sekitar_jakarta' => 'decimal:2',
        'biaya_hotel' => 'decimal:2',
        'total_biaya' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}