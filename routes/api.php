<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\SuratIjazahController;
use App\Http\Controllers\TandaTanganController;

// === PUBLIC ROUTES ===
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Info Publik (Lowongan, Berita, Info, Web Settings)
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/info', [InfoController::class, 'index']);
Route::get('/web-settings', [WebSettingController::class, 'index']);

// === PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {
    
    // Global Auth Route
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // ================== ALUMNI ROUTES ==================
    Route::middleware('role:alumni')->prefix('alumni')->group(function () {
        // Mengelola Profil Dasar
        Route::get('/profile', [AlumniController::class, 'profile']);
        Route::put('/profile', [AlumniController::class, 'updateProfile']);
        
        // Mengisi Tracer Study
        Route::post('/tracer-study', [TracerStudyController::class, 'store']);
        
        // Mengunduh Surat Pengantar Ijazah
        Route::post('/surat-ijazah/generate', [SuratIjazahController::class, 'generate']);
        Route::get('/surat-ijazah', [SuratIjazahController::class, 'getMine']);
    });

    // ================== ADMIN ROUTES ==================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Master Data & Akun
        Route::get('/fakultas', [MasterDataController::class, 'getFakultas']);
        Route::post('/fakultas', [MasterDataController::class, 'storeFakultas']);
        Route::delete('/fakultas/{id}', [MasterDataController::class, 'destroyFakultas']);
        Route::get('/prodi', [MasterDataController::class, 'getProdi']);
        Route::post('/prodi', [MasterDataController::class, 'storeProdi']);
        Route::delete('/prodi/{id}', [MasterDataController::class, 'destroyProdi']);
        Route::get('/alumni', [AlumniController::class, 'index']);
        
        // Mengelola Lowongan Pekerjaan
        Route::post('/jobs', [JobController::class, 'store']);
        Route::put('/jobs/{id}', [JobController::class, 'update']);
        Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

        // Mengelola Info Kampus & Berita
        Route::post('/info', [InfoController::class, 'store']);
        Route::put('/info/{id}', [InfoController::class, 'update']);
        Route::delete('/info/{id}', [InfoController::class, 'destroy']);
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{id}', [NewsController::class, 'update']);
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);
        Route::put('/web-settings', [WebSettingController::class, 'update']);

        // Mengelola Tanda Tangan Digital
        Route::post('/ttd', [TandaTanganController::class, 'upload']);
        Route::get('/ttd', [TandaTanganController::class, 'getMine']);
    });
});
