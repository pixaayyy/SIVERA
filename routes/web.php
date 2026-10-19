<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;

// Rute untuk halaman login dan proses autentikasi
Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
// Route::get('/login', [AuthController::class, 'index'])->name('login.get');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

<<<<<<< HEAD
// Rute grup untuk role Admin   
=======
// Rute untuk lupa kata sandi dan kirim email
Route::get('/lupa-sandi', [AuthController::class, 'lupaKatasandi'])->name('lupa-sandi')->middleware('guest');
Route::post('/lupa-sandi', [AuthController::class, 'prosesLupaKatasandi'])->name('lupa-sandi.post')->middleware('guest');

// Rute untuk reset kata sandi
Route::get('/reset-password/{token}', [AuthController::class, 'formResetKatasandi'])->name('reset-password.form');
Route::post('/reset-password', [AuthController::class, 'prosesResetKatasandi'])->name('reset-password.post');

// Rute grup untuk role Admin
>>>>>>> a4057dcb7e1dbe18c848d4ef1577e4a817f9454d
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
});

// Rute grup untuk role Karyawan
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanDashboard::class, 'index'])->name('karyawan.dashboard');
});