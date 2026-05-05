<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;  // <-- PAKAI DomPDF

class TripController extends Controller
{
    // ==================== HELPER FUNCTIONS ====================

    private function getUangHarianDalamNegeri()
    {
        return config('uang-harian.dalam_negeri');
    }

    private function getUangRepresentasi($eselon, $type = 'luar_kota')
    {
        // Jika eselon null atau kosong, anggap pegawai biasa
        if (empty($eselon) || $eselon === 'pegawai_biasa') {
            return 0;
        }
        
        $representasi = config('uang-harian.uang_representasi');
        return $representasi[$eselon][$type] ?? 0;
    }

    private function getUangHarianLuarNegeriByGolongan($negara, $golongan)
    {
        $data = config('uang-harian.luar_negeri')[$negara] ?? config('uang-harian.default_luar_negeri');
        
        if (is_array($data)) {
            return $data[$golongan] ?? $data['A'] ?? 400;
        }
        
        return $data;
    }

    private function getUangHarianPerHari($tujuan, $type, $golongan = 'A')
    {
        if ($type === 'dalam_negeri') {
            return config('uang-harian.dalam_negeri')[$tujuan] ?? config('uang-harian.default_dalam_negeri');
        }
        
        return $this->getUangHarianLuarNegeriByGolongan($tujuan, $golongan);
    }

    private function getBiayaTaxiTujuan($tujuan)
    {
        return config('uang-harian.transportasi_terminal_tujuan')[$tujuan] ?? config('uang-harian.default_transportasi_terminal');
    }

    // ==================== DALAM NEGERI ====================

    public function createDalamNegeri()
    {
        $provinsiOptions = array_keys(config('uang-harian.dalam_negeri'));
        sort($provinsiOptions);
        
        $kabupatenSekitarJakarta = array_keys(config('uang-harian.transportasi_sekitar_jakarta'));
        sort($kabupatenSekitarJakarta);
        
        // Tambahkan opsi PEGAWAI BIASA
        $eselonOptions = [
            'pejabat_negara' => 'Pejabat Negara/Wakil Menteri (Rp250.000/hari)',
            'eselon_i' => 'Eselon I (Rp200.000/hari)',
            'eselon_ii' => 'Eselon II (Rp150.000/hari)',
            'pegawai_biasa' => 'Pegawai Biasa (Tidak dapat representasi)',
        ];
        
        return view('trips.dalam-negeri.create', compact('provinsiOptions', 'kabupatenSekitarJakarta', 'eselonOptions'));
    }

    public function storeDalamNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'nullable|string|max:100',  // <-- TIDAK WAJIB
            'golongan' => 'nullable|string|max:50',  // <-- TIDAK WAJIB
            'jabatan' => 'required|string|max:255',
            'eselon' => 'nullable|string',  // <-- TIDAK WAJIB
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'biaya_transport_berangkat' => 'nullable|numeric|min:0',
            'biaya_taxi_jakarta' => 'nullable|numeric|min:0',
            'jenis_taxi_jakarta' => 'nullable|in:sekali_jalan,pp',
            'biaya_transport_pulang' => 'nullable|numeric|min:0',
            'biaya_taxi_tujuan' => 'nullable|numeric|min:0',
            'biaya_dalam_kota' => 'nullable|numeric|min:0',
            'biaya_transport_sekitar_jakarta' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $uangHarianPerHari = $this->getUangHarianPerHari($validated['tujuan'], 'dalam_negeri');
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        
        $uangRepresentasiPerHari = $this->getUangRepresentasi($validated['eselon'] ?? 'pegawai_biasa', 'luar_kota');
        $totalUangRepresentasi = $uangRepresentasiPerHari * $validated['lama_hari'];
        
        $biayaTransportBerangkat = $validated['biaya_transport_berangkat'] ?? 0;
        $biayaTaxiJakarta = $validated['biaya_taxi_jakarta'] ?? 0;
        $biayaTransportPulang = $validated['biaya_transport_pulang'] ?? 0;
        $biayaTaxiTujuan = $validated['biaya_taxi_tujuan'] ?? 0;
        $biayaDalamKota = $validated['biaya_dalam_kota'] ?? 0;
        $biayaTransportSekitarJakarta = $validated['biaya_transport_sekitar_jakarta'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        
        $totalBiaya = $totalUangHarian + $totalUangRepresentasi + $biayaTransportBerangkat 
                    + $biayaTaxiJakarta + $biayaTransportPulang + $biayaTaxiTujuan 
                    + $biayaDalamKota + $biayaTransportSekitarJakarta + $biayaHotel;

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'dalam_negeri',
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'] ?? null,
            'golongan' => $validated['golongan'] ?? null,
            'jabatan' => $validated['jabatan'],
            'eselon' => $validated['eselon'] ?? 'pegawai_biasa',
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
            'biaya_taxi_jakarta' => $biayaTaxiJakarta,
            'jenis_taxi_jakarta' => $validated['jenis_taxi_jakarta'] ?? null,
            'biaya_transport_pulang' => $biayaTransportPulang,
            'biaya_taxi_tujuan' => $biayaTaxiTujuan,
            'biaya_dalam_kota' => $biayaDalamKota,
            'biaya_transport_sekitar_jakarta' => $biayaTransportSekitarJakarta,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'IDR',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.dalam-negeri.pdf', $trip->id);
    }

    // ==================== LUAR NEGERI ====================

    public function createLuarNegeri()
    {
        $negaraOptions = array_keys(config('uang-harian.luar_negeri'));
        sort($negaraOptions);
        
        $golonganOptions = ['A', 'B', 'C', 'D'];
        
        // Tambahkan opsi PEGAWAI BIASA
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
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'biaya_transport_berangkat' => 'nullable|numeric|min:0',
            'biaya_transport_pulang' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $golonganLN = $validated['golongan_luar_negeri'];
        $uangHarianPerHari = $this->getUangHarianPerHari($validated['tujuan'], 'luar_negeri', $golonganLN);
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
            'nomor_surat' => $validated['nomor_surat'],
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

    // ==================== PDF GENERATION (PAKAI DomPDF) ====================

    public function generatePdfDalamNegeri($id)
    {
        $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        try {
            $html = view('trips.dalam-negeri.pdf', compact('trip'))->render();
        
            // Generate PDF langsung ke browser (tanpa simpan file)
            $pdf = PDF::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');
        
            return $pdf->download('surat_dinas_dalam_negeri_' . $trip->id . '.pdf');
        
        } catch (\Exception $e) {
            return back()->with('error', 'PDF Error: ' . $e->getMessage() . ' - Line: ' . $e->getLine());
        }
    }

    public function generatePdfLuarNegeri($id)
    {
        $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        try {
            $html = view('trips.luar-negeri.pdf', compact('trip'))->render();
        
            $pdf = PDF::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');
        
            return $pdf->download('surat_dinas_luar_negeri_' . $trip->id . '.pdf');
        
        } catch (\Exception $e) {
            return back()->with('error', 'PDF Error: ' . $e->getMessage() . ' - Line: ' . $e->getLine());
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
            
            if ($tujuan) {
                return response()->json([
                    'success' => true,
                    'uang_harian' => $data[$tujuan] ?? null,
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
        
        if ($tujuan) {
            $nilai = $data[$tujuan] ?? config('uang-harian.default_luar_negeri');
            
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