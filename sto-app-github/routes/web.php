<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/', [BarangController::class, 'dashboard'])->name('barang.dashboard');
Route::get('/detail-line/{line}', [BarangController::class, 'detailLine'])->name('barang.detail-line');

// Upload / Export / Master Data
Route::get('/upload', [BarangController::class, 'uploadForm'])->name('barang.upload');
Route::get('/export', [BarangController::class, 'exportPage'])->name('barang.export');
Route::get('/export/download', [BarangController::class, 'exportData'])->name('barang.export.download');
Route::get('/master-data', [BarangController::class, 'masterData'])->name('barang.master');

// CRUD Resources
Route::resource('barang', BarangController::class);
Route::post('barang/import', [BarangController::class, 'import'])->name('barang.import');

// User master data
Route::post('users/import', [UserController::class, 'import'])->name('users.import');
Route::get('users/export', [UserController::class, 'export'])->name('users.export');
Route::get('/settings', [BarangController::class, 'settings'])->name('settings');
Route::post('/settings/profile', [BarangController::class, 'updateProfile'])->name('settings.update.profile');
Route::post('/settings/preferences', [BarangController::class, 'updatePreferences'])->name('settings.update.preferences');
Route::resource('users', UserController::class);