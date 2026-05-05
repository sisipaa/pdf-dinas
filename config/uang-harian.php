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
    | Nilai uang harian per provinsi untuk perjalanan dinas dalam negeri
    | sesuai PMK 32 Tahun 2025 tentang Standar Biaya Masukan TA 2025
    |
    | Kolom: LUAR KOTA, DALAM KOTA (>8 JAM), DIKLAT
    */
    'dalam_negeri' => [
        'Aceh' => ['luar_kota' => 360000, 'dalam_kota' => 140000, 'diklat' => 110000],
        'Sumatera Utara' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Riau' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Kepulauan Riau' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Jambi' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Sumatera Barat' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Sumatera Selatan' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Lampung' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Bengkulu' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Bangka Belitung' => ['luar_kota' => 410000, 'dalam_kota' => 160000, 'diklat' => 120000],
        'Banten' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Jawa Barat' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'DKI Jakarta' => ['luar_kota' => 530000, 'dalam_kota' => 210000, 'diklat' => 160000],
        'Jawa Tengah' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'DI Yogyakarta' => ['luar_kota' => 420000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Jawa Timur' => ['luar_kota' => 410000, 'dalam_kota' => 160000, 'diklat' => 120000],
        'Bali' => ['luar_kota' => 480000, 'dalam_kota' => 190000, 'diklat' => 140000],
        'Nusa Tenggara Barat' => ['luar_kota' => 440000, 'dalam_kota' => 180000, 'diklat' => 130000],
        'Nusa Tenggara Timur' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Kalimantan Barat' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Kalimantan Tengah' => ['luar_kota' => 360000, 'dalam_kota' => 140000, 'diklat' => 110000],
        'Kalimantan Selatan' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Kalimantan Timur' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Kalimantan Utara' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Sulawesi Utara' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Gorontalo' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Sulawesi Barat' => ['luar_kota' => 410000, 'dalam_kota' => 160000, 'diklat' => 120000],
        'Sulawesi Selatan' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Sulawesi Tengah' => ['luar_kota' => 370000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Sulawesi Tenggara' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Maluku' => ['luar_kota' => 380000, 'dalam_kota' => 150000, 'diklat' => 110000],
        'Maluku Utara' => ['luar_kota' => 430000, 'dalam_kota' => 170000, 'diklat' => 130000],
        'Papua' => ['luar_kota' => 580000, 'dalam_kota' => 230000, 'diklat' => 170000],
        'Papua Barat' => ['luar_kota' => 480000, 'dalam_kota' => 190000, 'diklat' => 140000],
        'Papua Barat Daya' => ['luar_kota' => 480000, 'dalam_kota' => 190000, 'diklat' => 140000],
        'Papua Tengah' => ['luar_kota' => 580000, 'dalam_kota' => 230000, 'diklat' => 170000],
        'Papua Selatan' => ['luar_kota' => 580000, 'dalam_kota' => 230000, 'diklat' => 170000],
        'Papua Pegunungan' => ['luar_kota' => 580000, 'dalam_kota' => 230000, 'diklat' => 170000],
    ],

    /*
    |--------------------------------------------------------------------------
    | Uang Harian Perjalanan Dinas Luar Negeri (Golongan A/B/C/D)
    |--------------------------------------------------------------------------
    |
    | Nilai uang harian per negara untuk perjalanan dinas luar negeri
    | dalam USD (Dolar Amerika Serikat) sesuai PMK 32 Tahun 2025
    |
    | Golongan A, B, C, D berdasarkan jabatan/golongan pegawai
    */
    'luar_negeri' => [
        // AMERIKA UTARA
        'Amerika Serikat' => ['A' => 659, 'B' => 563, 'C' => 505, 'D' => 447],
        'Kanada' => ['A' => 552, 'B' => 467, 'C' => 416, 'D' => 365],
        
        // AMERIKA SELATAN
        'Argentina' => ['A' => 534, 'B' => 402, 'C' => 351, 'D' => 349],
        'Venezuela' => ['A' => 557, 'B' => 388, 'C' => 344, 'D' => 343],
        'Brasil' => ['A' => 436, 'B' => 396, 'C' => 378, 'D' => 351],
        'Chili' => ['A' => 434, 'B' => 370, 'C' => 332, 'D' => 294],
        'Kolombia' => ['A' => 466, 'B' => 413, 'C' => 405, 'D' => 365],
        'Peru' => ['A' => 459, 'B' => 352, 'C' => 320, 'D' => 280],
        'Suriname' => ['A' => 460, 'B' => 375, 'C' => 312, 'D' => 288],
        'Ekuador' => ['A' => 416, 'B' => 355, 'C' => 319, 'D' => 283],
        
        // AMERIKA TENGAH
        'Meksiko' => ['A' => 553, 'B' => 468, 'C' => 417, 'D' => 366],
        'Kuba' => ['A' => 453, 'B' => 385, 'C' => 345, 'D' => 305],
        'Panama' => ['A' => 418, 'B' => 357, 'C' => 320, 'D' => 283],
        
        // EROPA BARAT
        'Austria' => ['A' => 504, 'B' => 453, 'C' => 347, 'D' => 317],
        'Belgia' => ['A' => 538, 'B' => 456, 'C' => 406, 'D' => 357],
        'Perancis' => ['A' => 548, 'B' => 464, 'C' => 413, 'D' => 381],
        'Jerman' => ['A' => 485, 'B' => 415, 'C' => 368, 'D' => 324],
        'Belanda' => ['A' => 485, 'B' => 416, 'C' => 368, 'D' => 324],
        'Swiss' => ['A' => 636, 'B' => 570, 'C' => 444, 'D' => 401],
        
        // EROPA UTARA
        'Denmark' => ['A' => 569, 'B' => 491, 'C' => 428, 'D' => 375],
        'Finlandia' => ['A' => 521, 'B' => 442, 'C' => 394, 'D' => 346],
        'Norwegia' => ['A' => 621, 'B' => 559, 'C' => 389, 'D' => 386],
        'Swedia' => ['A' => 615, 'B' => 519, 'C' => 461, 'D' => 403],
        'Inggris' => ['A' => 792, 'B' => 774, 'C' => 583, 'D' => 582],
        
        // EROPA SELATAN
        'Bosnia dan Herzegovina' => ['A' => 456, 'B' => 420, 'C' => 334, 'D' => 333],
        'Kroasia' => ['A' => 555, 'B' => 506, 'C' => 406, 'D' => 405],
        'Spanyol' => ['A' => 457, 'B' => 413, 'C' => 335, 'D' => 296],
        'Yunani' => ['A' => 427, 'B' => 379, 'C' => 327, 'D' => 289],
        'Italia' => ['A' => 702, 'B' => 637, 'C' => 446, 'D' => 427],
        'Portugal' => ['A' => 462, 'B' => 405, 'C' => 333, 'D' => 302],
        'Serbia' => ['A' => 417, 'B' => 375, 'C' => 326, 'D' => 288],
        
        // EROPA TIMUR
        'Bulgaria' => ['A' => 406, 'B' => 367, 'C' => 320, 'D' => 284],
        'Ceko' => ['A' => 618, 'B' => 526, 'C' => 447, 'D' => 367],
        'Hongaria' => ['A' => 485, 'B' => 438, 'C' => 390, 'D' => 345],
        'Polandia' => ['A' => 478, 'B' => 415, 'C' => 363, 'D' => 320],
        'Rumania' => ['A' => 416, 'B' => 381, 'C' => 313, 'D' => 277],
        'Rusia' => ['A' => 556, 'B' => 512, 'C' => 407, 'D' => 406],
        'Slovakia' => ['A' => 437, 'B' => 394, 'C' => 341, 'D' => 303],
        'Ukraina' => ['A' => 485, 'B' => 436, 'C' => 375, 'D' => 333],
        
        // AFRIKA BARAT
        'Nigeria' => ['A' => 468, 'B' => 428, 'C' => 405, 'D' => 370],
        'Senegal' => ['A' => 461, 'B' => 393, 'C' => 336, 'D' => 311],
        'Kamerun' => ['A' => 468, 'B' => 428, 'C' => 405, 'D' => 370],
        
        // AFRIKA TIMUR
        'Etiopia' => ['A' => 420, 'B' => 374, 'C' => 330, 'D' => 285],
        'Kenya' => ['A' => 457, 'B' => 418, 'C' => 344, 'D' => 308],
        'Madagaskar' => ['A' => 543, 'B' => 366, 'C' => 330, 'D' => 295],
        'Tanzania' => ['A' => 458, 'B' => 386, 'C' => 357, 'D' => 303],
        'Zimbabwe' => ['A' => 430, 'B' => 400, 'C' => 330, 'D' => 316],
        'Mozambik' => ['A' => 472, 'B' => 436, 'C' => 356, 'D' => 319],
        
        // AFRIKA SELATAN
        'Namibia' => ['A' => 442, 'B' => 376, 'C' => 312, 'D' => 269],
        'Afrika Selatan' => ['A' => 440, 'B' => 400, 'C' => 363, 'D' => 317],
        
        // AFRIKA UTARA
        'Aljazair' => ['A' => 394, 'B' => 361, 'C' => 319, 'D' => 290],
        'Mesir' => ['A' => 481, 'B' => 426, 'C' => 405, 'D' => 361],
        'Maroko' => ['A' => 442, 'B' => 373, 'C' => 320, 'D' => 298],
        'Tunisia' => ['A' => 413, 'B' => 320, 'C' => 283, 'D' => 252],
        'Sudan' => ['A' => 443, 'B' => 408, 'C' => 358, 'D' => 280],
        'Libya' => ['A' => 456, 'B' => 393, 'C' => 340, 'D' => 320],
        
        // ASIA BARAT
        'Azerbaijan' => ['A' => 498, 'B' => 459, 'C' => 365, 'D' => 364],
        'Bahrain' => ['A' => 483, 'B' => 455, 'C' => 330, 'D' => 257],
        'Irak' => ['A' => 461, 'B' => 392, 'C' => 351, 'D' => 310],
        'Yordania' => ['A' => 504, 'B' => 428, 'C' => 382, 'D' => 336],
        'Kuwait' => ['A' => 581, 'B' => 491, 'C' => 437, 'D' => 383],
        'Libanon' => ['A' => 457, 'B' => 389, 'C' => 348, 'D' => 307],
        'Qatar' => ['A' => 509, 'B' => 448, 'C' => 349, 'D' => 290],
        'Suriah' => ['A' => 358, 'B' => 301, 'C' => 272, 'D' => 243],
        'Turki' => ['A' => 456, 'B' => 364, 'C' => 311, 'D' => 276],
        'Uni Emirat Arab' => ['A' => 594, 'B' => 502, 'C' => 446, 'D' => 391],
        'Yaman' => ['A' => 353, 'B' => 249, 'C' => 226, 'D' => 204],
        'Saudi Arabia' => ['A' => 468, 'B' => 398, 'C' => 356, 'D' => 314],
        'Kesultanan Oman' => ['A' => 516, 'B' => 437, 'C' => 390, 'D' => 343],
        
        // ASIA TIMUR
        'Republik Rakyat Tiongkok' => ['A' => 411, 'B' => 351, 'C' => 315, 'D' => 279],
        'Hongkong' => ['A' => 509, 'B' => 507, 'C' => 451, 'D' => 395],
        'Jepang' => ['A' => 519, 'B' => 428, 'C' => 382, 'D' => 336],
        'Korea Selatan' => ['A' => 515, 'B' => 467, 'C' => 425, 'D' => 421],
        'Korea Utara' => ['A' => 494, 'B' => 321, 'C' => 300, 'D' => 278],
        
        // ASIA SELATAN
        'Afganistan' => ['A' => 585, 'B' => 503, 'C' => 283, 'D' => 250],
        'Bangladesh' => ['A' => 390, 'B' => 347, 'C' => 287, 'D' => 257],
        'India' => ['A' => 422, 'B' => 329, 'C' => 327, 'D' => 325],
        'Pakistan' => ['A' => 480, 'B' => 408, 'C' => 305, 'D' => 263],
        'Srilanka' => ['A' => 457, 'B' => 362, 'C' => 337, 'D' => 280],
        'Iran' => ['A' => 421, 'B' => 332, 'C' => 299, 'D' => 266],
        
        // ASIA TENGAH
        'Uzbekistan' => ['A' => 458, 'B' => 395, 'C' => 317, 'D' => 282],
        'Kazakhstan' => ['A' => 456, 'B' => 420, 'C' => 334, 'D' => 333],
        
        // ASIA TENGGARA
        'Filipina' => ['A' => 450, 'B' => 380, 'C' => 287, 'D' => 265],
        'Singapura' => ['A' => 615, 'B' => 519, 'C' => 461, 'D' => 403],
        'Malaysia' => ['A' => 435, 'B' => 347, 'C' => 308, 'D' => 268],
        'Thailand' => ['A' => 420, 'B' => 358, 'C' => 318, 'D' => 278],
        'Myanmar' => ['A' => 382, 'B' => 283, 'C' => 273, 'D' => 245],
        'Laos' => ['A' => 380, 'B' => 277, 'C' => 251, 'D' => 225],
        'Vietnam' => ['A' => 407, 'B' => 343, 'C' => 297, 'D' => 253],
        'Brunei Darussalam' => ['A' => 374, 'B' => 278, 'C' => 252, 'D' => 226],
        'Kamboja' => ['A' => 347, 'B' => 282, 'C' => 277, 'D' => 250],
        'Timor Leste' => ['A' => 392, 'B' => 354, 'C' => 236, 'D' => 212],
        
        // ASIA PASIFIK
        'Australia' => ['A' => 636, 'B' => 585, 'C' => 424, 'D' => 393],
        'Selandia Baru' => ['A' => 545, 'B' => 461, 'C' => 411, 'D' => 361],
        'Kaledonia Baru' => ['A' => 445, 'B' => 400, 'C' => 368, 'D' => 280],
        'Papua Nugini' => ['A' => 520, 'B' => 476, 'C' => 429, 'D' => 376],
        'Fiji' => ['A' => 427, 'B' => 365, 'C' => 327, 'D' => 289],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mapping Golongan ke Kategori (A/B/C/D)
    |--------------------------------------------------------------------------
    | Golongan I = A
    | Golongan II = B
    | Golongan III = C
    | Golongan IV = D
    */
    'golongan_to_kategori' => [
        'I' => 'A',
        'II' => 'B',
        'III' => 'C',
        'IV' => 'D',
    ],

    /*
    |--------------------------------------------------------------------------
    | Biaya Taxi Tujuan (Dari/Ke Terminal/Bandara/Stasiun/Pelabuhan)
    |--------------------------------------------------------------------------
    | Biaya taxi dari Bandara/Stasiun/Terminal di lokasi tujuan
    | Sesuai PMK 32 Tahun 2025
    */
    'taxi_tujuan' => [
        'Aceh' => 123000,
        'Sumatera Utara' => 278000,
        'Riau' => 99000,
        'Kepulauan Riau' => 159000,
        'Jambi' => 133000,
        'Sumatera Barat' => 171000,
        'Sumatera Selatan' => 162000,
        'Lampung' => 162000,
        'Bengkulu' => 106000,
        'Bangka Belitung' => 94000,
        'Banten' => 300000,
        'Jawa Barat' => 180000,
        'DKI Jakarta' => 250000,
        'Jawa Tengah' => 105000,
        'DI Yogyakarta' => 258000,
        'Jawa Timur' => 225000,
        'Bali' => 219000,
        'Nusa Tenggara Barat' => 224000,
        'Nusa Tenggara Timur' => 105000,
        'Kalimantan Barat' => 165000,
        'Kalimantan Tengah' => 130000,
        'Kalimantan Selatan' => 174000,
        'Kalimantan Timur' => 300000,
        'Kalimantan Utara' => 211000,
        'Sulawesi Utara' => 134000,
        'Gorontalo' => 256000,
        'Sulawesi Barat' => 283000,
        'Sulawesi Selatan' => 181000,
        'Sulawesi Tengah' => 149000,
        'Sulawesi Tenggara' => 154000,
        'Maluku' => 279000,
        'Maluku Utara' => 208000,
        'Papua' => 462000,
        'Papua Barat' => 228000,
        'Papua Barat Daya' => 228000,
        'Papua Tengah' => 228000,
        'Papua Selatan' => 228000,
        'Papua Pegunungan' => 228000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Biaya Taxi Jakarta (Fixed) dari bandara/stasiun/terminal ke lokasi
    |--------------------------------------------------------------------------
    | Biaya taxi tetap untuk perjalanan dari bandara/stasiun/terminal Jakarta
    | ke lokasi tujuan sebesar Rp274.000 (1 kali jalan)
    | Pilihan: 1 Kali Jalan atau PP (Pulang Pergi)
    */
    'taxi_jakarta' => 274000,

    /*
    |--------------------------------------------------------------------------
    | Transportasi Dalam Kota Jakarta (Fixed)
    |--------------------------------------------------------------------------
    | Transportasi sekitar Jakarta atau di Jakarta saja
    */
    'transport_dalam_kota_jakarta' => 170000,

    /*
    |--------------------------------------------------------------------------
    | Transportasi Antar Kabupaten/Kota Sekitar Jakarta (ONE WAY)
    |--------------------------------------------------------------------------
    | Biaya transportasi dari DKI Jakarta ke Kabupaten/Kota sekitar
    */
    'transport_antar_kabupaten' => [
        'Kota Bekasi' => 256000,
        'Kab. Bekasi' => 256000,
        'Kab. Bogor' => 270000,
        'Kota Bogor' => 270000,
        'Kota Depok' => 248000,
        'Kota Tangerang' => 258000,
        'Kota Tangerang Selatan' => 258000,
        'Kab. Tangerang' => 279000,
        'Kepulauan Seribu' => 386000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Uang Representasi Perjalanan Dinas Dalam Negeri
    |--------------------------------------------------------------------------
    | Uang representasi untuk perjalanan dinas dalam negeri
    | Berdasarkan PDF: LUAR KOTA dan DALAM KOTA (>8 JAM)
    */
    'uang_representasi' => [
        'Pejabat Negara/Wakil Menteri' => ['luar_kota' => 250000, 'dalam_kota' => 125000],
        'Eselon I' => ['luar_kota' => 200000, 'dalam_kota' => 100000],
        'Eselon II' => ['luar_kota' => 150000, 'dalam_kota' => 75000],
        'eselon_iii' => ['luar_kota' => 0, 'dalam_kota' => 0],
        'pegawai_biasa' => ['luar_kota' => 0, 'dalam_kota' => 0],
    ],

    /*
    |--------------------------------------------------------------------------
    | Uang Harian Kegiatan Rapat/Pertemuan di Luar Kantor
    |--------------------------------------------------------------------------
    | Biaya fullboard untuk rapat/pertemuan di luar kantor
    */
    'uang_harian_rapat' => [
        'fullboard' => 130000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Values (Fallback)
    |--------------------------------------------------------------------------
    */
    'default_dalam_negeri_luar_kota' => 370000,
    'default_luar_negeri' => 300,
    'default_golongan_kategori' => 'C',

    /*
    |--------------------------------------------------------------------------
    | Mapping Provinsi dari Kota
    |--------------------------------------------------------------------------
    | Untuk menentukan taxi tujuan berdasarkan provinsi
    */
    'kota_to_provinsi' => [
        // DKI Jakarta
        'DKI Jakarta' => 'DKI Jakarta',
        'Jakarta' => 'DKI Jakarta',
        
        // Banten
        'Serang' => 'Banten',
        'Tangerang' => 'Banten',
        'Cilegon' => 'Banten',
        'Tangerang Selatan' => 'Banten',
        
        // Jawa Barat
        'Bandung' => 'Jawa Barat',
        'Bekasi' => 'Jawa Barat',
        'Bogor' => 'Jawa Barat',
        'Depok' => 'Jawa Barat',
        'Cimahi' => 'Jawa Barat',
        'Tasikmalaya' => 'Jawa Barat',
        'Cirebon' => 'Jawa Barat',
        'Sukabumi' => 'Jawa Barat',
        
        // Jawa Tengah
        'Semarang' => 'Jawa Tengah',
        'Surakarta' => 'Jawa Tengah',
        'Magelang' => 'Jawa Tengah',
        'Salatiga' => 'Jawa Tengah',
        'Tegal' => 'Jawa Tengah',
        'Pekalongan' => 'Jawa Tengah',
        
        // Jawa Timur
        'Surabaya' => 'Jawa Timur',
        'Malang' => 'Jawa Timur',
        'Madiun' => 'Jawa Timur',
        'Kediri' => 'Jawa Timur',
        'Blitar' => 'Jawa Timur',
        'Mojokerto' => 'Jawa Timur',
        'Pasuruan' => 'Jawa Timur',
        'Probolinggo' => 'Jawa Timur',
        'Batu' => 'Jawa Timur',
        
        // DI Yogyakarta
        'Yogyakarta' => 'DI Yogyakarta',
        
        // Sumatera
        'Medan' => 'Sumatera Utara',
        'Padang' => 'Sumatera Barat',
        'Palembang' => 'Sumatera Selatan',
        'Bandar Lampung' => 'Lampung',
        'Pekanbaru' => 'Riau',
        'Jambi' => 'Jambi',
        'Bengkulu' => 'Bengkulu',
        'Pangkal Pinang' => 'Bangka Belitung',
        'Tanjung Pinang' => 'Kepulauan Riau',
        'Batam' => 'Kepulauan Riau',
        'Banda Aceh' => 'Aceh',
        
        // Bali
        'Denpasar' => 'Bali',
        
        // Nusa Tenggara
        'Mataram' => 'Nusa Tenggara Barat',
        'Kupang' => 'Nusa Tenggara Timur',
        
        // Kalimantan
        'Pontianak' => 'Kalimantan Barat',
        'Palangka Raya' => 'Kalimantan Tengah',
        'Banjarmasin' => 'Kalimantan Selatan',
        'Samarinda' => 'Kalimantan Timur',
        'Balikpapan' => 'Kalimantan Timur',
        'Tarakan' => 'Kalimantan Utara',
        
        // Sulawesi
        'Manado' => 'Sulawesi Utara',
        'Palu' => 'Sulawesi Tengah',
        'Makassar' => 'Sulawesi Selatan',
        'Kendari' => 'Sulawesi Tenggara',
        'Gorontalo' => 'Gorontalo',
        'Mamuju' => 'Sulawesi Barat',
        
        // Maluku
        'Ambon' => 'Maluku',
        'Ternate' => 'Maluku Utara',
        
        // Papua
        'Jayapura' => 'Papua',
        'Sorong' => 'Papua Barat',
        'Manokwari' => 'Papua Barat',
    ],
];