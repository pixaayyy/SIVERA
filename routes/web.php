<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;


// Halaman utama langsung mengarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::get('/lupa-sandi', [PasswordResetLinkController::class, 'create'])->name('lupa-sandi');
Route::post('/lupa-sandi', [PasswordResetLinkController::class, 'store'])->name('lupa-sandi.post');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

// Halaman Dashboard Berdasarkan Role (Diproteksi middleware auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanDashboard::class, 'index'])->name('karyawan.dashboard');
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});


