<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TripController extends Controller
{
    // ==================== HELPER FUNCTIONS ====================

    private function getUangHarianDalamNegeri($provinsi, $type = 'luar_kota')
    {
        $data = config('uang-harian.dalam_negeri');
        if (isset($data[$provinsi]) && is_array($data[$provinsi])) {
            return $data[$provinsi][$type] ?? $data[$provinsi]['luar_kota'] ?? 370000;
        }
        return config('uang-harian.default_dalam_negeri_luar_kota', 370000);
    }

    private function getUangRepresentasi($eselon, $type = 'luar_kota')
    {
        if (empty($eselon) || $eselon === 'pegawai_biasa') {
            return 0;
        }
        
        $mapping = [
            'pejabat_negara' => 'Pejabat Negara/Wakil Menteri',
            'eselon_i' => 'Eselon I',
            'eselon_ii' => 'Eselon II',
            'eselon_iii' => 'eselon_iii',
        ];
        
        $key = $mapping[$eselon] ?? $eselon;
        $representasi = config('uang-harian.uang_representasi');
        return $representasi[$key][$type] ?? 0;
    }

    private function getUangHarianLuarNegeriByGolongan($negara, $golongan)
    {
        $data = config('uang-harian.luar_negeri');
        
        if (isset($data[$negara]) && is_array($data[$negara])) {
            return $data[$negara][$golongan] ?? $data[$negara]['A'] ?? 400;
        }
        
        return config('uang-harian.default_luar_negeri', 300);
    }

    // ==================== DALAM NEGERI ====================

    public function createDalamNegeri()
    {
        $dalamNegeri = config('uang-harian.dalam_negeri');
        $provinsiOptions = is_array($dalamNegeri) ? array_keys($dalamNegeri) : [];
        sort($provinsiOptions);
        
        $transportasiSekitar = config('uang-harian.transportasi_sekitar_jakarta');
        $kabupatenSekitarJakarta = is_array($transportasiSekitar) ? $transportasiSekitar : [];
        
        $taxiTujuan = config('uang-harian.taxi_tujuan');
        $taxiTujuanData = is_array($taxiTujuan) ? $taxiTujuan : [];
        
        $eselonOptions = [
            '' => 'Tidak ada (Pegawai Biasa)',
            'pejabat_negara' => 'Pejabat Negara/Wakil Menteri (Rp250.000/hari)',
            'eselon_i' => 'Eselon I (Rp200.000/hari)',
            'eselon_ii' => 'Eselon II (Rp150.000/hari)',
        ];
        
        return view('trips.dalam-negeri.create', compact(
            'provinsiOptions', 
            'kabupatenSekitarJakarta', 
            'taxiTujuanData',
            'eselonOptions'
        ));
    }

    public function storeDalamNegeri(Request $request)
{
    try {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'eselon' => 'nullable|string',
            'jenis_perjalanan' => 'required|in:fullboard,dalam_kota_jakarta,sekitar_jakarta,luar_kota',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'nullable|in:darat,udara',
            'tempat_keberangkatan' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string|max:255',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date',
            'biaya_transport_berangkat' => 'nullable|numeric|min:0',
            'biaya_transport_pulang' => 'nullable|numeric|min:0',
            'biaya_taxi_keberangkatan' => 'nullable|numeric|min:0',
            'biaya_taxi_tujuan' => 'nullable|numeric|min:0',
            'biaya_transport_sekitar' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
            'uang_harian_manual' => 'nullable|numeric|min:0',
        ]);

        $jenisPerjalanan = $validated['jenis_perjalanan'];
        $lamaHari = $validated['lama_hari'];
            
            // Default values
            $uangHarianPerHari = 0;
            $biayaTransportBerangkat = $validated['biaya_transport_berangkat'] ?? 0;
            $biayaTransportPulang = $validated['biaya_transport_pulang'] ?? 0;
            $biayaTaxiKeberangkatan = $validated['biaya_taxi_keberangkatan'] ?? 0;
            $biayaTaxiTujuan = $validated['biaya_taxi_tujuan'] ?? 0;
            $biayaTransportSekitar = $validated['biaya_transport_sekitar'] ?? 0;
            $biayaHotel = $validated['biaya_hotel'] ?? 0;
            $biayaDalamKota = 0;
            $tujuan = $validated['tujuan'] ?? '';
            $tempatKeberangkatan = $validated['tempat_keberangkatan'] ?? 'Jakarta';
            $jenisAngkutan = $validated['jenis_angkutan'] ?? 'udara';
            
            // Hitung berdasarkan jenis perjalanan
          
        
        switch ($jenisPerjalanan) {
            case 'fullboard':
                $tujuan = 'Rapat/Pertemuan (Fullboard)';
                $uangHarianPerHari = 130000;
                $jenisAngkutan = 'darat';
                $tempatKeberangkatan = 'Jakarta';
                break;
                
            case 'dalam_kota_jakarta':
                $tujuan = 'DKI Jakarta (Dalam Kota)';
                $uangHarianPerHari = $validated['uang_harian_manual'] ?? 210000;
                $jenisAngkutan = 'darat';
                $tempatKeberangkatan = 'Jakarta';
                break;
                
            case 'sekitar_jakarta':
                if (empty($tujuan)) {
                    $tujuan = 'Sekitar Jakarta';
                }
                $uangHarianPerHari = 430000; // Default Jawa Barat
                $jenisAngkutan = 'darat';
                $tempatKeberangkatan = 'Jakarta';
                break;
                
            case 'luar_kota':
                if (empty($tujuan)) {
                    $tujuan = 'Luar Kota';
                }
                $uangHarianPerHari = $this->getUangHarianDalamNegeri($tujuan, 'luar_kota');
                $jenisAngkutan = $validated['jenis_angkutan'] ?? 'udara';
                $tempatKeberangkatan = $validated['tempat_keberangkatan'] ?? 'Jakarta';
                break;
                
            default:
                $tujuan = 'Tidak ditentukan';
                $uangHarianPerHari = 370000;
                $jenisAngkutan = 'darat';
                $tempatKeberangkatan = 'Jakarta';
        }
        
        $totalUangHarian = $uangHarianPerHari * $lamaHari;
        
        $uangRepresentasiPerHari = $this->getUangRepresentasi($validated['eselon'] ?? '', 'luar_kota');
        $totalUangRepresentasi = $uangRepresentasiPerHari * $lamaHari;
        
        $biayaTransportBerangkat = $validated['biaya_transport_berangkat'] ?? 0;
        $biayaTransportPulang = $validated['biaya_transport_pulang'] ?? 0;
        $biayaTaxiTujuan = $validated['biaya_taxi_tujuan'] ?? 0;
        $biayaTransportSekitar = $validated['biaya_transport_sekitar'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $biayaDalamKota = ($jenisPerjalanan == 'dalam_kota_jakarta' || $jenisPerjalanan == 'sekitar_jakarta') ? 170000 : 0;
        
        $totalBiaya = $totalUangHarian + $totalUangRepresentasi 
                    + $biayaTransportBerangkat + $biayaTransportPulang
                    + $biayaTaxiTujuan + $biayaDalamKota + $biayaTransportSekitar + $biayaHotel;

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'dalam_negeri',
            'nomor_surat' => $validated['nomor_surat'] ?? null,
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'] ?? null,
            'golongan' => $validated['golongan'] ?? null,
            'jabatan' => $validated['jabatan'],
            'eselon' => $validated['eselon'] ?? 'pegawai_biasa',
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $jenisAngkutan,
            'tempat_keberangkatan' => $tempatKeberangkatan,
            'tujuan' => $tujuan, // PASTI ADA
            'lama_hari' => $lamaHari,
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'uang_representasi_per_hari' => $uangRepresentasiPerHari,
            'total_uang_representasi' => $totalUangRepresentasi,
            'biaya_transport_berangkat' => $biayaTransportBerangkat,
            'biaya_taxi_jakarta' => 0,
            'jenis_taxi_jakarta' => 'sekali_jalan',
            'biaya_transport_pulang' => $biayaTransportPulang,
            'biaya_taxi_tujuan' => $biayaTaxiTujuan,
            'biaya_dalam_kota' => $biayaDalamKota,
            'biaya_transport_sekitar_jakarta' => $biayaTransportSekitar,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'IDR',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.dalam-negeri.pdf', $trip->id);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}

    // ==================== LUAR NEGERI ====================

    public function createLuarNegeri()
    {
        $luarNegeri = config('uang-harian.luar_negeri');
        $negaraOptions = is_array($luarNegeri) ? array_keys($luarNegeri) : [];
        sort($negaraOptions);
        
        $golonganOptions = ['A', 'B', 'C', 'D'];
        
        $eselonOptions = [
            'pejabat_negara' => 'Pejabat Negara/Wakil Menteri (Rp250.000/hari)',
            'eselon_i' => 'Eselon I (Rp200.000/hari)',
            'eselon_ii' => 'Eselon II (Rp150.000/hari)',
            'pegawai_biasa' => 'Pegawai Biasa (Tidak dapat representasi)',
        ];
        
        return view('trips.luar-negeri.create', compact('negaraOptions', 'golonganOptions', 'eselonOptions'));
    }

    public function storeLuarNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'nullable|string|max:100',
            'golongan' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'eselon' => 'nullable|string',
            'golongan_luar_negeri' => 'required|in:A,B,C,D',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara,laut',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'biaya_transport_berangkat' => 'nullable|numeric|min:0',
            'biaya_transport_pulang' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $golonganLN = $validated['golongan_luar_negeri'];
        $uangHarianPerHari = $this->getUangHarianLuarNegeriByGolongan($validated['tujuan'], $golonganLN);
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        
        $uangRepresentasiPerHari = $this->getUangRepresentasi($validated['eselon'] ?? 'pegawai_biasa', 'luar_kota');
        $totalUangRepresentasi = $uangRepresentasiPerHari * $validated['lama_hari'];
        
        $biayaTransportBerangkat = $validated['biaya_transport_berangkat'] ?? 0;
        $biayaTransportPulang = $validated['biaya_transport_pulang'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        
        $totalBiaya = $totalUangHarian + $totalUangRepresentasi + $biayaTransportBerangkat 
                    + $biayaTransportPulang + $biayaHotel;

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'luar_negeri',
            'nomor_surat' => $validated['nomor_surat'] ?? null,
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'] ?? null,
            'golongan' => $validated['golongan'] ?? null,
            'jabatan' => $validated['jabatan'],
            'eselon' => $validated['eselon'] ?? 'pegawai_biasa',
            'golongan_luar_negeri' => $validated['golongan_luar_negeri'],
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'uang_representasi_per_hari' => $uangRepresentasiPerHari,
            'total_uang_representasi' => $totalUangRepresentasi,
            'biaya_transport_berangkat' => $biayaTransportBerangkat,
            'biaya_transport_pulang' => $biayaTransportPulang,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'USD',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.luar-negeri.pdf', $trip->id);
    }

    // ==================== PDF GENERATION ====================

    public function generatePdfDalamNegeri($id)
{
    $trip = Trip::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    try {

        $pdf = PDF::loadView(
            'trips.dalam-negeri.pdf',
            compact('trip')
        );

        $pdf->setPaper('A4', 'portrait');

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'defaultFont' => 'Times New Roman',
        ]);

        return $pdf->download(
            'surat_dinas_dalam_negeri_' . $trip->id . '.pdf'
        );

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);

    }
}

    public function generatePdfLuarNegeri($id)
{
    $trip = Trip::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    try {

        $pdf = PDF::loadView(
        'trips.luar-negeri.pdf',
        compact('trip')
     );
        $pdf->setPaper('A4', 'portrait');

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'defaultFont' => 'Times New Roman',
        ]);

        return $pdf->download(
            'surat_dinas_luar_negeri_' . $trip->id . '.pdf'
        );

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);

    }
}

    public function downloadPerType($id, $type)
{
    $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $viewMap = [
        'spd' => 'trips.dalam-negeri.partials.spd',
        'rincian' => 'trips.dalam-negeri.partials.rincian',
        'kwitansi' => 'trips.dalam-negeri.partials.kwitansi',
        'riil' => 'trips.dalam-negeri.partials.riil',
        'perjalanan' => 'trips.dalam-negeri.partials.perjalanan',
        'nominatif' => 'trips.dalam-negeri.partials.nominatif',
        'semua' => 'trips.dalam-negeri.pdf',
    ];

    if (!isset($viewMap[$type])) {
        abort(404, 'Tipe surat tidak ditemukan');
    }

    try {
        $html = view($viewMap[$type], compact('trip'))->render();
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('surat_dinas_' . $type . '_' . $trip->id . '.pdf');
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}

    public function downloadPdf($id)
{
    $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    if (!$trip->file_pdf || !file_exists(storage_path('app/public/' . $trip->file_pdf))) {
        if ($trip->type === 'dalam_negeri') {
            return $this->generatePdfDalamNegeri($id);
        } else {
            return $this->generatePdfLuarNegeri($id);
        }
    }

    $filePath = storage_path('app/public/' . $trip->file_pdf);
    return response()->download($filePath);
}



    // ==================== HELPER ====================

    public function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $terbilang = $this->terbilang((int)($angka / 10)) . ' Puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' Seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang((int)($angka / 100)) . ' Ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' Seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang((int)($angka / 1000)) . ' Ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang((int)($angka / 1000000)) . ' Juta' . $this->terbilang($angka % 1000000);
        }

        return trim($terbilang);
    }

    public function getUangHarian(Request $request)
    {
        $type = $request->get('type', 'dalam_negeri');
        $tujuan = $request->get('tujuan');
        $golongan = $request->get('golongan', 'A');

        if ($type === 'dalam_negeri') {
            $data = config('uang-harian.dalam_negeri');
            
            if ($tujuan && isset($data[$tujuan])) {
                return response()->json([
                    'success' => true,
                    'uang_harian' => $data[$tujuan],
                    'mata_uang' => 'IDR',
                ]);
            }
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'mata_uang' => 'IDR',
            ]);
        }
        
        $data = config('uang-harian.luar_negeri');
        
        if ($tujuan && isset($data[$tujuan])) {
            $nilai = $data[$tujuan];
            
            if (is_array($nilai)) {
                $uangHarian = $nilai[$golongan] ?? $nilai['A'] ?? 400;
            } else {
                $uangHarian = $nilai;
            }
            
            return response()->json([
                'success' => true,
                'uang_harian' => $uangHarian,
                'mata_uang' => 'USD',
                'golongan' => $golongan,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'mata_uang' => 'USD',
        ]);
    }
}