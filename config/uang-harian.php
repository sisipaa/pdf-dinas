<?php

/**
 * Konfigurasi Uang Harian Perjalanan Dinas
 * Berdasarkan PMK 32 Tahun 2025
 *
 * Sumber: Peraturan Menteri Keuangan Nomor 32/PMK.05/2025
 * tentang Standar Biaya Masukan Tahun Anggaran 2025
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Uang Harian Perjalanan Dinas Dalam Negeri
    |--------------------------------------------------------------------------
    |
    | Nilai uang harian per kota/provinsi untuk perjalanan dinas dalam negeri
    | sesuai PMK 32 Tahun 2025 tentang Standar Biaya Masukan TA 2025
    |
    */
    'dalam_negeri' => [
        // Provinsi DKI Jakarta
        'DKI Jakarta' => 550000,

        // Provinsi Jawa Barat
        'Bandung' => 509000,
        'Bekasi' => 509000,
        'Bogor' => 509000,
        'Depok' => 509000,
        'Cimahi' => 509000,
        'Tasikmalaya' => 509000,
        'Cirebon' => 509000,
        'Sukabumi' => 509000,

        // Provinsi Jawa Tengah
        'Semarang' => 465000,
        'Surakarta' => 465000,
        'Magelang' => 465000,
        'Salatiga' => 465000,
        'Tegal' => 465000,
        'Pekalongan' => 465000,

        // Provinsi Jawa Timur
        'Surabaya' => 509000,
        'Malang' => 465000,
        'Madiun' => 465000,
        'Kediri' => 465000,
        'Blitar' => 465000,
        'Mojokerto' => 465000,
        'Pasuruan' => 465000,
        'Probolinggo' => 465000,
        'Batu' => 465000,

        // Provinsi DI Yogyakarta
        'Yogyakarta' => 465000,

        // Provinsi Banten
        'Serang' => 509000,
        'Tangerang' => 509000,
        'Cilegon' => 509000,
        'Tangerang Selatan' => 509000,

        // Provinsi Sumatera Utara
        'Medan' => 550000,
        'Binjai' => 550000,
        'Pematangsiantar' => 550000,
        'Tebing Tinggi' => 550000,
        'Tanjungbalai' => 550000,
        'Sibolga' => 550000,
        'Padangsidimpuan' => 550000,
        'Gunungsitoli' => 550000,

        // Provinsi Sumatera Barat
        'Padang' => 509000,
        'Bukittinggi' => 509000,
        'Padangpanjang' => 509000,
        'Pariaman' => 509000,
        'Payakumbuh' => 509000,
        'Sawah Lunto' => 509000,
        'Solok' => 509000,

        // Provinsi Sumatera Selatan
        'Palembang' => 550000,
        'Prabumulih' => 550000,
        'Pagar Alam' => 550000,
        'Lubuklinggau' => 550000,

        // Provinsi Lampung
        'Bandar Lampung' => 509000,
        'Metro' => 509000,

        // Provinsi Riau
        'Pekanbaru' => 550000,
        'Dumai' => 550000,

        // Provinsi Jambi
        'Jambi' => 509000,
        'Sungai Penuh' => 509000,

        // Provinsi Bengkulu
        'Bengkulu' => 509000,

        // Provinsi Bangka Belitung
        'Pangkal Pinang' => 550000,

        // Provinsi Kepulauan Riau
        'Tanjung Pinang' => 550000,
        'Batam' => 550000,

        // Provinsi Aceh
        'Banda Aceh' => 550000,
        'Sabang' => 550000,
        'Lhokseumawe' => 550000,
        'Langsa' => 550000,
        'Subulussalam' => 550000,

        // Provinsi Bali
        'Denpasar' => 550000,

        // Provinsi Nusa Tenggara Barat
        'Mataram' => 509000,
        'Bima' => 509000,

        // Provinsi Nusa Tenggara Timur
        'Kupang' => 509000,

        // Provinsi Kalimantan Barat
        'Pontianak' => 550000,
        'Singkawang' => 550000,

        // Provinsi Kalimantan Tengah
        'Palangka Raya' => 550000,

        // Provinsi Kalimantan Selatan
        'Banjarmasin' => 550000,
        'Banjarbaru' => 550000,

        // Provinsi Kalimantan Timur
        'Samarinda' => 603000,
        'Balikpapan' => 603000,
        'Bontang' => 603000,

        // Provinsi Kalimantan Utara
        'Tarakan' => 603000,
        'Tanjung Selor' => 603000,

        // Provinsi Sulawesi Utara
        'Manado' => 550000,
        'Bitung' => 550000,
        'Tomohon' => 550000,
        'Kotamobagu' => 550000,

        // Provinsi Sulawesi Tengah
        'Palu' => 550000,

        // Provinsi Sulawesi Selatan
        'Makassar' => 550000,
        'Parepare' => 550000,
        'Palopo' => 550000,

        // Provinsi Sulawesi Tenggara
        'Kendari' => 550000,
        'Bau-Bau' => 550000,

        // Provinsi Gorontalo
        'Gorontalo' => 509000,

        // Provinsi Sulawesi Barat
        'Mamuju' => 550000,

        // Provinsi Maluku
        'Ambon' => 603000,
        'Tual' => 603000,

        // Provinsi Maluku Utara
        'Ternate' => 603000,
        'Tidore Kepulauan' => 603000,

        // Provinsi Papua
        'Jayapura' => 656000,

        // Provinsi Papua Barat
        'Sorong' => 656000,
        'Manokwari' => 656000,

        // Provinsi Papua Tengah
        'Nabire' => 656000,

        // Provinsi Papua Pegunungan
        'Wamena' => 656000,

        // Provinsi Papua Selatan
        'Merauke' => 656000,

        // Provinsi Papua Barat Daya
        'Fak-Fak' => 656000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Uang Harian Perjalanan Dinas Luar Negeri
    |--------------------------------------------------------------------------
    |
    | Nilai uang harian per negara untuk perjalanan dinas luar negeri
    | dalam USD (Dolar Amerika Serikat) sesuai PMK 32 Tahun 2025
    |
    */
    'luar_negeri' => [
        // Asia
        'Singapura' => 187,
        'Malaysia' => 171,
        'Thailand' => 171,
        'Filipina' => 171,
        'Vietnam' => 171,
        'Korea Selatan' => 215,
        'Jepang' => 231,
        'Taiwan' => 187,
        'Hong Kong' => 215,
        'Tiongkok' => 187,
        'India' => 154,
        'Pakistan' => 154,
        'Bangladesh' => 154,
        'Sri Lanka' => 154,
        'Nepal' => 154,
        'Myanmar' => 171,
        'Kamboja' => 171,
        'Laos' => 171,
        'Brunei Darussalam' => 187,
        'Timor Leste' => 171,
        'Arab Saudi' => 187,
        'Uni Emirat Arab' => 187,
        'Qatar' => 187,
        'Kuwait' => 187,
        'Bahrain' => 187,
        'Oman' => 187,
        'Iran' => 171,
        'Irak' => 171,
        'Yordania' => 171,
        'Lebanon' => 171,
        'Turki' => 171,
        'Israel' => 215,
        'Kazakhstan' => 171,
        'Uzbekistan' => 171,

        // Eropa
        'Inggris' => 231,
        'Prancis' => 215,
        'Jerman' => 215,
        'Italia' => 215,
        'Spanyol' => 215,
        'Belanda' => 215,
        'Swiss' => 262,
        'Belgia' => 215,
        'Austria' => 215,
        'Swedia' => 231,
        'Norwegia' => 262,
        'Denmark' => 262,
        'Finlandia' => 231,
        'Polandia' => 171,
        'Portugal' => 187,
        'Yunani' => 187,
        'Rusia' => 187,
        'Ukraina' => 171,
        'Ceko' => 187,
        'Hongaria' => 171,
        'Romania' => 171,
        'Bulgaria' => 171,
        'Kroasia' => 187,
        'Serbia' => 171,
        'Irlandia' => 215,
        'Islandia' => 262,
        'Luxembourg' => 215,

        // Amerika
        'Amerika Serikat' => 231,
        'Kanada' => 215,
        'Brazil' => 187,
        'Argentina' => 171,
        'Chili' => 187,
        'Kolombia' => 171,
        'Peru' => 171,
        'Meksiko' => 187,
        'Venezuela' => 171,
        'Ekuador' => 171,
        'Uruguay' => 171,
        'Kuba' => 171,
        'Panama' => 171,
        'Kosta Rika' => 171,
        'Jamaika' => 171,
        'Trinidad dan Tobago' => 171,

        // Afrika
        'Afrika Selatan' => 187,
        'Mesir' => 171,
        'Nigeria' => 171,
        'Kenya' => 171,
        'Ethiopia' => 171,
        'Ghana' => 171,
        'Tanzania' => 171,
        'Uganda' => 171,
        'Aljazair' => 171,
        'Maroko' => 171,
        'Tunisia' => 171,
        'Libya' => 171,
        'Senegal' => 171,
        'Kamerun' => 171,
        'Pantai Gading' => 171,
        'Zimbabwe' => 171,
        'Botswana' => 171,
        'Namibia' => 171,
        'Zambia' => 171,
        'Mozambik' => 171,
        'Angola' => 187,
        'Rwanda' => 171,
        'Sudan' => 171,

        // Oceania
        'Australia' => 231,
        'Selandia Baru' => 215,
        'Papua Nugini' => 187,
        'Fiji' => 171,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Values
    |--------------------------------------------------------------------------
    */
    'default_dalam_negeri' => 465000,
    'default_luar_negeri' => 171,
];
