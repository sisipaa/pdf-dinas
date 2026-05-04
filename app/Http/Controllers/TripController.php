<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    /**
     * Get uang harian config dari config file
     */
    private function getUangHarianDalamNegeri()
    {
        return config('uang-harian.dalam_negeri');
    }

    private function getUangHarianLuarNegeri()
    {
        return config('uang-harian.luar_negeri');
    }

    /**
     * Get uang harian per hari untuk dalam negeri
     * @param string $tujuan Provinsi tujuan
     * @param string $tipePerjalanan 'luar_kota' atau 'dalam_kota'
     */
    private function getUangHarianDalamNegeriPerHari($tujuan, $tipePerjalanan = 'luar_kota')
    {
        $data = config('uang-harian.dalam_negeri')[$tujuan] ?? null;
        
        if ($data) {
            return $tipePerjalanan === 'dalam_kota' ? $data['dalam_kota'] : $data['luar_kota'];
        }
        
        return config('uang-harian.default_dalam_negeri_luar_kota', 370000);
    }

    /**
     * Get uang harian per hari untuk luar negeri berdasarkan golongan
     * @param string $negara Negara tujuan
     * @param string $golongan Golongan pegawai (I, II, III, IV)
     */
    private function getUangHarianLuarNegeriPerHari($negara, $golongan)
    {
        $data = config('uang-harian.luar_negeri')[$negara] ?? null;
        
        // Mapping golongan ke kategori (A/B/C/D)
        $golonganToKategori = config('uang-harian.golongan_to_kategori', []);
        preg_match('/([I|V]+)/', $golongan, $matches);
        $golonganAngka = $matches[1] ?? 'III';
        $kategori = $golonganToKategori[$golonganAngka] ?? config('uang-harian.default_golongan_kategori', 'C');
        
        if ($data && isset($data[$kategori])) {
            return $data[$kategori];
        }
        
        return config('uang-harian.default_luar_negeri', 300);
    }

    /**
     * Get provinsi dari kota tujuan
     */
    private function getProvinsiFromKota($kota)
    {
        return config('uang-harian.kota_to_provinsi')[$kota] ?? null;
    }

    /**
     * Get biaya taxi tujuan berdasarkan provinsi
     */
    private function getTaxiTujuanBiaya($provinsi)
    {
        return config('uang-harian.taxi_tujuan')[$provinsi] ?? 0;
    }

    /**
     * Get uang representasi berdasarkan jabatan dan tipe perjalanan
     * @param string $eselonJabatan
     * @param string $tipePerjalanan 'luar_kota' atau 'dalam_kota'
     */
    private function getUangRepresentasi($eselonJabatan, $tipePerjalanan = 'luar_kota')
    {
        $uangRepresentasi = config('uang-harian.uang_representasi');
        
        // Mapping jabatan ke key config
        $jabatanKey = null;
        if ($eselonJabatan === 'Eselon I') {
            $jabatanKey = 'Eselon I';
        } elseif ($eselonJabatan === 'Eselon II') {
            $jabatanKey = 'Eselon II';
        } elseif (in_array($eselonJabatan, ['Pejabat Negara', 'Wakil Menteri'])) {
            $jabatanKey = 'Pejabat Negara/Wakil Menteri';
        }
        
        if ($jabatanKey && isset($uangRepresentasi[$jabatanKey])) {
            return $tipePerjalanan === 'dalam_kota' ? $uangRepresentasi[$jabatanKey]['dalam_kota'] : $uangRepresentasi[$jabatanKey]['luar_kota'];
        }
        
        return 0;
    }

    /**
     * Get biaya transport antar kabupaten sekitar Jakarta
     */
    private function getTransportAntarKabupaten($kotaTujuan)
    {
        return config('uang-harian.transport_antar_kabupaten')[$kotaTujuan] ?? 0;
    }

    public function createDalamNegeri()
    {
        $provinsiOptions = array_keys(config('uang-harian.dalam_negeri'));
        sort($provinsiOptions);
        $kabupatenOptions = array_keys(config('uang-harian.transport_antar_kabupaten'));
        sort($kabupatenOptions);
        return view('trips.dalam-negeri.create', compact('provinsiOptions', 'kabupatenOptions'));
    }

    public function storeDalamNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'required|string|max:100',
            'golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'eselon_jabatan' => 'nullable|string|in:Pejabat Negara,Wakil Menteri,Eselon I,Eselon II,Staf',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'tipe_perjalanan' => 'nullable|in:luar_kota,dalam_kota',

            // Transportasi detail
            'transportasi_luar_kota_type' => 'nullable|in:Pesawat,Kereta,Bus,Kapal,BBM',
            'transportasi_luar_kota_biaya' => 'nullable|numeric|min:0',

            // Taxi Jakarta
            'taxi_jakarta_type' => 'nullable|in:1 Kali Jalan,PP',
            'taxi_jakarta_biaya' => 'nullable|numeric|min:0',

            // Taxi Tujuan (otomatis)
            'taxi_tujuan_provinsi' => 'nullable|string|max:100',
            'taxi_tujuan_biaya' => 'nullable|numeric|min:0',

            // Transportasi dalam kota Jakarta
            'gunakan_transport_dalam_kota' => 'nullable|boolean',
            'transport_dalam_kota_biaya' => 'nullable|numeric|min:0',
            
            // Transportasi antar kabupaten sekitar Jakarta
            'gunakan_transport_antar_kabupaten' => 'nullable|boolean',
            'tujuan_antar_kabupaten' => 'nullable|string',

            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $tipePerjalanan = $validated['tipe_perjalanan'] ?? 'luar_kota';
        
        // Hitung komponen biaya
        $uangHarianPerHari = $this->getUangHarianDalamNegeriPerHari($validated['tujuan'], $tipePerjalanan);
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];

        // Transportasi luar kota (input manual)
        $transportasiLuarKotaBiaya = $validated['transportasi_luar_kota_biaya'] ?? 0;

        // Taxi Jakarta (fixed Rp274.000 x multiplier)
        $taxiJakartaType = $validated['taxi_jakarta_type'] ?? null;
        $taxiJakartaBiaya = 0;
        if ($taxiJakartaType === '1 Kali Jalan') {
            $taxiJakartaBiaya = config('uang-harian.taxi_jakarta');
        } elseif ($taxiJakartaType === 'PP') {
            $taxiJakartaBiaya = config('uang-harian.taxi_jakarta') * 2;
        }

        // Taxi Tujuan (otomatis berdasarkan provinsi)
        $provinsi = $this->getProvinsiFromKota($validated['tujuan']);
        $taxiTujuanBiaya = $provinsi ? $this->getTaxiTujuanBiaya($provinsi) : 0;

        // Transportasi dalam kota Jakarta
        $transportDalamKotaBiaya = 0;
        if (!empty($validated['gunakan_transport_dalam_kota'])) {
            $transportDalamKotaBiaya = config('uang-harian.transport_dalam_kota_jakarta');
        }
        
        // Transportasi antar kabupaten sekitar Jakarta
        $transportAntarKabupatenBiaya = 0;
        if (!empty($validated['gunakan_transport_antar_kabupaten']) && !empty($validated['tujuan_antar_kabupaten'])) {
            $transportAntarKabupatenBiaya = $this->getTransportAntarKabupaten($validated['tujuan_antar_kabupaten']);
        }

        // Total biaya transportasi
        $totalBiayaTransport = $transportasiLuarKotaBiaya + $taxiJakartaBiaya + $taxiTujuanBiaya + $transportDalamKotaBiaya + $transportAntarKabupatenBiaya;

        // Uang Representasi berdasarkan eselon jabatan
        $eselonJabatan = $validated['eselon_jabatan'] ?? null;
        $uangRepresentasi = $eselonJabatan ? $this->getUangRepresentasi($eselonJabatan, $tipePerjalanan) : 0;

        // Biaya hotel
        $biayaHotel = $validated['biaya_hotel'] ?? 0;

        // Total keseluruhan
        $totalBiaya = $totalUangHarian + $totalBiayaTransport + $uangRepresentasi + $biayaHotel;

        Log::info('Detail Biaya Dinas Dalam Negeri', [
            'tujuan' => $validated['tujuan'],
            'provinsi' => $provinsi,
            'tipe_perjalanan' => $tipePerjalanan,
            'uang_harian_per_hari' => $uangHarianPerHari,
            'lama_hari' => $validated['lama_hari'],
            'total_uang_harian' => $totalUangHarian,
            'transportasi_luar_kota_biaya' => $transportasiLuarKotaBiaya,
            'taxi_jakarta_type' => $taxiJakartaType,
            'taxi_jakarta_biaya' => $taxiJakartaBiaya,
            'taxi_tujuan_biaya' => $taxiTujuanBiaya,
            'transport_dalam_kota_biaya' => $transportDalamKotaBiaya,
            'transport_antar_kabupaten_biaya' => $transportAntarKabupatenBiaya,
            'uang_representasi' => $uangRepresentasi,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
        ]);

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'dalam_negeri',
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'],
            'golongan' => $validated['golongan'],
            'jabatan' => $validated['jabatan'],
            'eselon_jabatan' => $eselonJabatan,
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'tipe_perjalanan' => $tipePerjalanan,
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'transportasi_luar_kota_type' => $validated['transportasi_luar_kota_type'] ?? null,
            'transportasi_luar_kota_biaya' => $transportasiLuarKotaBiaya,
            'taxi_jakarta_type' => $taxiJakartaType,
            'taxi_jakarta_biaya' => $taxiJakartaBiaya,
            'taxi_tujuan_provinsi' => $provinsi,
            'taxi_tujuan_biaya' => $taxiTujuanBiaya,
            'gunakan_transport_dalam_kota' => !empty($validated['gunakan_transport_dalam_kota']),
            'transport_dalam_kota_biaya' => $transportDalamKotaBiaya,
            'uang_representasi' => $uangRepresentasi,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'IDR',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.dalam-negeri.pdf', $trip->id);
    }

    public function createLuarNegeri()
    {
        $negaraOptions = array_keys(config('uang-harian.luar_negeri'));
        sort($negaraOptions);
        return view('trips.luar-negeri.create', compact('negaraOptions'));
    }

    public function storeLuarNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'required|string|max:100',
            'golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'jenis_transport' => 'nullable|in:luar kota,taxi,dalam kota',
            'biaya_transport' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        // Hitung uang harian berdasarkan golongan
        $uangHarianPerHari = $this->getUangHarianLuarNegeriPerHari($validated['tujuan'], $validated['golongan']);
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        $biayaTransport = $validated['biaya_transport'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $totalBiaya = $totalUangHarian + $biayaTransport + $biayaHotel;
        
        // Hitung kategori golongan
        $golonganToKategori = config('uang-harian.golongan_to_kategori', []);
        preg_match('/([I|V]+)/', $validated['golongan'], $matches);
        $golonganAngka = $matches[1] ?? 'III';
        $kategoriGolongan = $golonganToKategori[$golonganAngka] ?? config('uang-harian.default_golongan_kategori', 'C');

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'luar_negeri',
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'],
            'golongan' => $validated['golongan'],
            'jabatan' => $validated['jabatan'],
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'kategori_golongan' => $kategoriGolongan,
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'jenis_transport' => $validated['jenis_transport'] ?? null,
            'biaya_transport' => $biayaTransport,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'USD',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.luar-negeri.pdf', $trip->id);
    }

    /**
     * Generate PDF menggunakan DOMPDF (compatible dengan Railway)
     */
    private function generatePdf($html, $filename)
    {
        $pdf = Pdf::loadHTML($html, [
            'defaultFont' => 'Times New Roman',
            'defaultPaperSize' => 'a4',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf->setPaper('a4')
            ->setOption('margin-top', 20)
            ->setOption('margin-right', 20)
            ->setOption('margin-bottom', 20)
            ->setOption('margin-left', 20);

        // Simpan ke storage
        $pdfPath = storage_path('app/public/pdfs/' . $filename);

        // Pastikan direktori ada
        $dir = dirname($pdfPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $pdf->save($pdfPath);

        return $pdfPath;
    }

    public function generatePdfDalamNegeri($id)
    {
        try {
            $trip = Trip::findOrFail($id);

            $html = view('trips.dalam-negeri.pdf', compact('trip'))->render();

            $filename = 'surat_dinas_dalam_negeri_' . $trip->id . '_' . time() . '.pdf';

            // Generate PDF dengan DOMPDF
            $pdfPath = $this->generatePdf($html, $filename);

            $trip->update(['file_pdf' => 'pdfs/' . $filename]);

            return response()->file($pdfPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Failed to generate PDF',
                'message' => env('APP_DEBUG', false) ? $e->getMessage() : 'An error occurred while generating the PDF',
            ], 500);
        }
    }

    public function generatePdfLuarNegeri($id)
    {
        try {
            $trip = Trip::findOrFail($id);

            $html = view('trips.luar-negeri.pdf', compact('trip'))->render();

            $filename = 'surat_dinas_luar_negeri_' . $trip->id . '_' . time() . '.pdf';

            // Generate PDF dengan DOMPDF
            $pdfPath = $this->generatePdf($html, $filename);

            $trip->update(['file_pdf' => 'pdfs/' . $filename]);

            return response()->file($pdfPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('PDF Generation Error (Luar Negeri): ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Failed to generate PDF',
                'message' => env('APP_DEBUG', false) ? $e->getMessage() : 'An error occurred while generating the PDF',
            ], 500);
        }
    }

    public function downloadPdf($id)
    {
        $trip = Trip::findOrFail($id);

        if (!$trip->file_pdf) {
            if ($trip->type === 'dalam_negeri') {
                return $this->generatePdfDalamNegeri($id);
            } else {
                return $this->generatePdfLuarNegeri($id);
            }
        }

        $filePath = storage_path('app/public/' . $trip->file_pdf);

        if (!file_exists($filePath)) {
            if ($trip->type === 'dalam_negeri') {
                return $this->generatePdfDalamNegeri($id);
            } else {
                return $this->generatePdfLuarNegeri($id);
            }
        }

        return response()->download($filePath);
    }

    /**
     * Helper function untuk terbilang
     */
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
            $terbilang = $this->terbilang($angka / 10) . ' Puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' Seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang($angka / 100) . ' Ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' Seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang($angka / 1000) . ' Ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang($angka / 1000000) . ' Juta' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000) . ' Milyar' . $this->terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000000) . ' Trilyun' . $this->terbilang(fmod($angka, 1000000000000));
        }

        return $terbilang;
    }

    /**
     * API endpoint untuk mendapatkan uang harian
     */
    public function getUangHarian(Request $request)
    {
        $type = $request->get('type', 'dalam_negeri');
        $tujuan = $request->get('tujuan');
        $golongan = $request->get('golongan');
        $tipePerjalanan = $request->get('tipe_perjalanan', 'luar_kota');

        if ($type === 'dalam_negeri') {
            if ($tujuan) {
                $data = $this->getUangHarianDalamNegeriPerHari($tujuan, $tipePerjalanan);
                return response()->json([
                    'success' => true,
                    'uang_harian' => $data,
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => config('uang-harian.dalam_negeri'),
            ]);
        } else {
            if ($tujuan && $golongan) {
                $data = $this->getUangHarianLuarNegeriPerHari($tujuan, $golongan);
                return response()->json([
                    'success' => true,
                    'uang_harian' => $data,
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => config('uang-harian.luar_negeri'),
            ]);
        }
    }
}