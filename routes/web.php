<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PASIENController;
use App\Http\Controllers\STAFController;
use App\Http\Controllers\DOKTERController;
use App\Http\Controllers\REKAM_MEDISController;
use App\Http\Controllers\JANJI_TEMUController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cek-db', function () {
    try {
        DB::connection('oracle')->getPdo();
        return "✅ Koneksi ke Oracle Database berhasil!";
    } catch (\Exception $e) {
        return "❌ Gagal koneksi ke Oracle. Error: " . $e->getMessage();
    }
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dokter Routes
Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DOKTERController::class, 'index'])->name('index');
    Route::get('/create', [DOKTERController::class, 'create'])->name('create');
    Route::post('/', [DOKTERController::class, 'store'])->name('store');
    Route::get('/{id}', [DOKTERController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [DOKTERController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DOKTERController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [DOKTERController::class, 'delete'])->name('delete'); // Halaman konfirmasi delete
    Route::delete('/{id}', [DOKTERController::class, 'destroy'])->name('destroy'); // Actual delete
});

// Pasien Routes
Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/', [PASIENController::class, 'index'])->name('index');
    Route::get('/create', [PASIENController::class, 'create'])->name('create');
    Route::post('/', [PASIENController::class, 'store'])->name('store');
    Route::get('/{id}', [PASIENController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PASIENController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PASIENController::class, 'update'])->name('update');
    Route::delete('/{id}', [PASIENController::class, 'destroy'])->name('destroy');
});

// Rekam Medis Routes
    Route::prefix('rekam_medis')->name('rekam_medis.')->group(function () {
    Route::get('/', [REKAM_MEDISController::class, 'index'])->name('index');
    Route::get('/create', [REKAM_MEDISController::class, 'create'])->name('create');
    Route::post('/', [REKAM_MEDISController::class, 'store'])->name('store');
    Route::get('/{id}', [REKAM_MEDISController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [REKAM_MEDISController::class, 'edit'])->name('edit');
    Route::put('/{id}', [REKAM_MEDISController::class, 'update'])->name('update');
    Route::delete('/{id}', [REKAM_MEDISController::class, 'destroy'])->name('destroy');
    Route::get('/pasien/{id}', [REKAM_MEDISController::class, 'byPasien'])->name('by_pasien');
    Route::get('/dokter/{id}', [REKAM_MEDISController::class, 'byDokter'])->name('by_dokter');
    Route::get('/statistik', [REKAM_MEDISController::class, 'statistik'])->name('statistik');
    Route::get('/search', [REKAM_MEDISController::class, 'search'])->name('search');
    Route::get('/export', [REKAM_MEDISController::class, 'export'])->name('export');
});

// Janji Temu Routes
Route::prefix('janji_temu')->name('janji_temu.')->group(function () {
    Route::get('/', [JANJI_TEMUController::class, 'index'])->name('index');
    Route::get('/create', [JANJI_TEMUController::class, 'create'])->name('create');
    Route::post('/', [JANJI_TEMUController::class, 'store'])->name('store');
    Route::get('/pasien/{idPasien}', [JANJI_TEMUController::class, 'byPasien'])->name('by_pasien');
    Route::get('/dokter/{idDokter}', [JANJI_TEMUController::class, 'byDokter'])->name('by_dokter');
    Route::get('/{id}', [JANJI_TEMUController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [JANJI_TEMUController::class, 'edit'])->name('edit');
    Route::put('/{id}', [JANJI_TEMUController::class, 'update'])->name('update');
    Route::delete('/{id}', [JANJI_TEMUController::class, 'destroy'])->name('destroy');
});

// Staf Routes
Route::prefix('staf')->name('staf.')->group(function () {
    Route::get('/', [STAFController::class, 'index'])->name('index');
    Route::get('/create', [STAFController::class, 'create'])->name('create');
    Route::post('/', [STAFController::class, 'store'])->name('store');
    Route::get('/{id}', [STAFController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [STAFController::class, 'edit'])->name('edit');
    Route::put('/{id}', [STAFController::class, 'update'])->name('update');
    Route::delete('/{id}', [STAFController::class, 'destroy'])->name('destroy');
});

Route::get('/pendaftaran-ktp', function() {
    return 'Selamat datang di halaman Pendaftaran KTP Online!';
})->middleware ('check.age');

Route::get('/upload', [ImageController::class, 'create']);
Route::post('/upload', [ImageController::class, 'store'])->name('image.upload');
Route::delete('/upload/{id}', [ImageController::class, 'destroy'])->name('image.destroy');