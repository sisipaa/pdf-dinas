<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
   protected $fillable = [
    'user_id', 'type', 'nomor_surat', 'tanggal_keberangkatan',
    'nama', 'nip', 'pangkat', 'golongan', 'jabatan', 'eselon',
    'golongan_luar_negeri', // untuk luar negeri
    'maksud_perjalanan', 'jenis_angkutan', 'tempat_keberangkatan',
    'tujuan', 'lama_hari', 'tanggal_kembali',
    'uang_harian_per_hari', 'total_uang_harian',
    'uang_representasi_per_hari', 'total_uang_representasi',
    'biaya_transport_berangkat', 'biaya_taxi_jakarta', 'jenis_taxi_jakarta',
    'biaya_transport_pulang', 'biaya_taxi_tujuan', 'biaya_dalam_kota',
    'biaya_transport_sekitar_jakarta', 'biaya_hotel', 'total_biaya',
    'mata_uang', 'file_pdf', 'status',
];
    protected $casts = [
        'tanggal_keberangkatan' => 'date',
        'tanggal_kembali' => 'date',
        'uang_harian_per_hari' => 'decimal:2',
        'total_uang_harian' => 'decimal:2',
        'transportasi_luar_kota_biaya' => 'decimal:2',
        'taxi_jakarta_biaya' => 'decimal:2',
        'taxi_tujuan_biaya' => 'decimal:2',
        'transport_dalam_kota_biaya' => 'decimal:2',
        'uang_representasi' => 'decimal:2',
        'biaya_transport' => 'decimal:2',
        'biaya_hotel' => 'decimal:2',
        'total_biaya' => 'decimal:2',
        'gunakan_transport_dalam_kota' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get kategori golongan untuk luar negeri     * Berdasarkan golongan (I, II, III, IV)
     */
    public function getKategoriGolonganAttribute()
    {
        $golonganToKategori = config('uang-harian.golongan_to_kategori', []);
        
        // Ambil angka dari golongan (contoh: "III/a" -> "III")
        preg_match('/([I|V]+)/', $this->golongan, $matches);
        $golonganAngka = $matches[1] ?? 'III';
        
        return $golonganToKategori[$golonganAngka] ?? config('uang-harian.default_golongan_kategori', 'C');
    }
}