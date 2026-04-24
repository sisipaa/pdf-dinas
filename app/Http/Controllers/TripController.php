<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;

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

    private function getUangHarianPerHari($tujuan, $type)
    {
        if ($type === 'dalam_negeri') {
            return config('uang-harian.dalam_negeri')[$tujuan] ?? config('uang-harian.default_dalam_negeri');
        }
        return config('uang-harian.luar_negeri')[$tujuan] ?? config('uang-harian.default_luar_negeri');
    }

    public function createDalamNegeri()
    {
        $kotaOptions = array_keys(config('uang-harian.dalam_negeri'));
        sort($kotaOptions);
        return view('trips.dalam-negeri.create', compact('kotaOptions'));
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

        $uangHarianPerHari = $this->getUangHarianPerHari($validated['tujuan'], 'dalam_negeri');
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        $biayaTransport = $validated['biaya_transport'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $totalBiaya = $totalUangHarian + $biayaTransport + $biayaHotel;

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
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'jenis_transport' => $validated['jenis_transport'] ?? null,
            'biaya_transport' => $biayaTransport,
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

        $uangHarianPerHari = $this->getUangHarianPerHari($validated['tujuan'], 'luar_negeri');
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        $biayaTransport = $validated['biaya_transport'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $totalBiaya = $totalUangHarian + $biayaTransport + $biayaHotel;

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
     * Configure Browsershot untuk Railway deployment
     */
    private function getBrowsershot(): Browsershot
    {
        $browsershot = Browsershot::html('')
            ->setOption('viewport.width', 1920)
            ->setOption('viewport.height', 1080)
            ->addChromiumArguments([
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-setuid-sandbox',
                '--disable-accelerated-2d-canvas',
                '--disable-gpu',
            ]);

        // Check jika running di Railway
        if (env('RAILWAY_ENVIRONMENT')) {
            $browsershot->setChromePath('/usr/bin/chromium');
        }

        return $browsershot;
    }

    public function generatePdfDalamNegeri($id)
    {
        $trip = Trip::findOrFail($id);

        $html = view('trips.dalam-negeri.pdf', compact('trip'))->render();

        $filename = 'surat_dinas_dalam_negeri_' . $trip->id . '_' . time() . '.pdf';
        $pdfPath = storage_path('app/public/pdfs/' . $filename);

        // Pastikan direktori ada
        $dir = dirname($pdfPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Generate PDF dengan Browsershot
        $this->getBrowsershot()
            ->setHtml($html)
            ->paperSize(210, 297) // A4 in mm
            ->margin(20, 20, 20, 20) // mm: top, right, bottom, left
            ->save($pdfPath);

        $trip->update(['file_pdf' => 'pdfs/' . $filename]);

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function generatePdfLuarNegeri($id)
    {
        $trip = Trip::findOrFail($id);

        $html = view('trips.luar-negeri.pdf', compact('trip'))->render();

        $filename = 'surat_dinas_luar_negeri_' . $trip->id . '_' . time() . '.pdf';
        $pdfPath = storage_path('app/public/pdfs/' . $filename);

        // Pastikan direktori ada
        $dir = dirname($pdfPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Generate PDF dengan Browsershot
        $this->getBrowsershot()
            ->setHtml($html)
            ->paperSize(210, 297) // A4 in mm
            ->margin(20, 20, 20, 20) // mm: top, right, bottom, left
            ->save($pdfPath);

        $trip->update(['file_pdf' => 'pdfs/' . $filename]);

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
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

        if ($type === 'dalam_negeri') {
            $data = config('uang-harian.dalam_negeri');
        } else {
            $data = config('uang-harian.luar_negeri');
        }

        if ($tujuan) {
            return response()->json([
                'success' => true,
                'uang_harian' => $data[$tujuan] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
