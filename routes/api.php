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
use App\Http\Controllers\NotificationController;

// === PUBLIC ROUTES ===
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
// Info Publik (Lowongan, Berita, Info, Web Settings)
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/info', [InfoController::class, 'index']);
Route::get('/info/{id}', [InfoController::class, 'show']);
Route::get('/web-settings', [WebSettingController::class, 'index']);
Route::get('/stats', [DashboardController::class, 'stats']);

// Master Data Publik (untuk form daftar/register)
Route::get('/fakultas', [MasterDataController::class, 'getFakultas']);
Route::get('/prodi', [MasterDataController::class, 'getProdi']);

// Info Publik (Lowongan, Berita, Info, Web Settings)
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/info', [InfoController::class, 'index']);
Route::get('/info/{id}', [InfoController::class, 'show']);
Route::get('/web-settings', [WebSettingController::class, 'index']);
Route::get('/stats', [DashboardController::class, 'stats']);
Route::get('/fakultas', [MasterDataController::class, 'getFakultas']);
Route::get('/prodi', [MasterDataController::class, 'getProdi']);

// === PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {
    
    // Global Auth Route
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::put('/auth/password', [AuthController::class, 'updatePassword']);

    // Notifications (Global for authenticated users)
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    // ================== ALUMNI ROUTES ==================
    Route::middleware('role:alumni')->prefix('alumni')->group(function () {
        // Mengelola Profil Dasar
        Route::get('/profile', [AlumniController::class, 'profile']);
        Route::put('/profile', [AlumniController::class, 'updateProfile']);
        
        // Mengisi Tracer Study
        Route::post('/tracer-study', [TracerStudyController::class, 'store']);
        
        // Mengunduh Surat Pengantar Ijazah
        Route::post('/surat-ijazah/upload', [SuratIjazahController::class, 'upload']);
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
        Route::put('/alumni/{id}', [AlumniController::class, 'update']);
        Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
        
        // Mengelola Lowongan Pekerjaan
        Route::post('/jobs', [JobController::class, 'store']);
        Route::put('/jobs/{id}', [JobController::class, 'update']);
        Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

        // Mengelola Info Kampus & Berita
        Route::get('/info', [InfoController::class, 'indexAdmin']);
        Route::post('/info', [InfoController::class, 'store']);
        Route::put('/info/{id}', [InfoController::class, 'update']);
        Route::delete('/info/{id}', [InfoController::class, 'destroy']);
        Route::get('/news', [NewsController::class, 'indexAdmin']);
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{id}', [NewsController::class, 'update']);
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);
        Route::put('/web-settings', [WebSettingController::class, 'update']);

        // Mengelola Tanda Tangan Digital
        Route::post('/ttd', [TandaTanganController::class, 'upload']);
        Route::get('/ttd', [TandaTanganController::class, 'getMine']);

        // Verifikasi Surat Ijazah
        Route::get('/surat-ijazah', [SuratIjazahController::class, 'adminIndex']);
        Route::put('/surat-ijazah/{id}/verify', [SuratIjazahController::class, 'adminVerify']);
        Route::delete('/surat-ijazah/{id}', [SuratIjazahController::class, 'destroy']);
    });
});
