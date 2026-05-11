<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/test-pdf', function() {
    try {
        $pdf = Barryvdh\DomPDF\Facade\Pdf::loadHTML('<h1>Test PDF</h1><p>If you see this, DomPDF works!</p>');
        return $pdf->download('test.pdf');
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/test-spd', function() {
    $trip = \App\Models\Trip::first();
    if (!$trip) {
        return 'No trip found. Create one first.';
    }
    try {
        return view('trips.dalam-negeri.partials.spd', compact('trip'))->render();
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . '<br>File: ' . $e->getFile() . '<br>Line: ' . $e->getLine();
    }
});

Route::get('/test-full-pdf-ln', function() {
    $trip = \App\Models\Trip::where('type', 'luar_negeri')->first();
    if (!$trip) {
        return 'No luar negeri trip found. Create one first.';
    }
    try {
        $html = view('trips.luar-negeri.pdf', compact('trip'))->render();
        
        // Test generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('test-luar-negeri.pdf');
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . '<br>File: ' . $e->getFile() . '<br>Line: ' . $e->getLine();
    }
});

// Download PDF per tipe
Route::get('/trips/{id}/download/{type}', [TripController::class, 'downloadPerType'])->name('trips.download.type');

Route::get('/phpinfo', function() {
    phpinfo();
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dinas Dalam Negeri
    Route::get('/trips/dalam-negeri/create', [TripController::class, 'createDalamNegeri'])->name('trips.dalam-negeri.create');
    Route::post('/trips/dalam-negeri', [TripController::class, 'storeDalamNegeri'])->name('trips.dalam-negeri.store');
    Route::get('/trips/dalam-negeri/{id}/pdf', [TripController::class, 'generatePdfDalamNegeri'])->name('trips.dalam-negeri.pdf');

    // Dinas Luar Negeri
    Route::get('/trips/luar-negeri/create', [TripController::class, 'createLuarNegeri'])->name('trips.luar-negeri.create');
    Route::post('/trips/luar-negeri', [TripController::class, 'storeLuarNegeri'])->name('trips.luar-negeri.store');
    Route::get('/trips/luar-negeri/{id}/pdf', [TripController::class, 'generatePdfLuarNegeri'])->name('trips.luar-negeri.pdf');

    // Download PDF
    Route::get('/trips/{id}/download', [TripController::class, 'downloadPdf'])->name('trips.download');

    // API endpoint for uang harian
    Route::get('/api/uang-harian', [TripController::class, 'getUangHarian']);
});
