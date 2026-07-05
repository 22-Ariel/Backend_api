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

// === PUBLIC ROUTES ===
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/info', [InfoController::class, 'index']);
Route::get('/web-settings', [WebSettingController::class, 'index']);

// === PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // === ALUMNI ROUTES ===
    Route::middleware('role:alumni')->group(function () {
        Route::get('/alumni/profile', [AlumniController::class, 'profile']);
        Route::put('/alumni/profile', [AlumniController::class, 'updateProfile']);
        Route::post('/alumni/avatar', [AlumniController::class, 'uploadAvatar']);
    });

    // === ADMIN ROUTES ===
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

        // Alumni Management
        Route::get('/alumni', [AlumniController::class, 'index']);
        Route::get('/alumni/{id}', [AlumniController::class, 'show']);
        Route::put('/alumni/{id}', [AlumniController::class, 'update']);
        Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);

        // Job Management
        Route::post('/jobs', [JobController::class, 'store']);
        Route::put('/jobs/{id}', [JobController::class, 'update']);
        Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

        // News Management
        Route::get('/news', [NewsController::class, 'indexAdmin']);
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{id}', [NewsController::class, 'update']);
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);

        // Info Management
        Route::get('/info', [InfoController::class, 'indexAdmin']);
        Route::post('/info', [InfoController::class, 'store']);
        Route::put('/info/{id}', [InfoController::class, 'update']);
        Route::delete('/info/{id}', [InfoController::class, 'destroy']);

        // Web Settings
        Route::put('/web-settings', [WebSettingController::class, 'update']);
    });
});
