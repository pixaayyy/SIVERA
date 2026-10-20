<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\TambahbarangController;
use App\Http\Controllers\Karyawan\DataBarangController;
use App\Http\Controllers\Karyawan\EditBarangController;
use App\Http\Controllers\NotifikasiController;

// Rute untuk halaman login dan proses autentikasi
Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk lupa kata sandi dan kirim email
Route::get('/lupa-sandi', [AuthController::class, 'lupaKatasandi'])->name('lupa-sandi')->middleware('guest');
Route::post('/lupa-sandi', [AuthController::class, 'prosesLupaKatasandi'])->name('lupa-sandi.post')->middleware('guest');

// Rute untuk reset kata sandi
Route::get('/reset-password/{token}', [AuthController::class, 'formResetKatasandi'])->name('reset-password.form');
Route::post('/reset-password', [AuthController::class, 'prosesResetKatasandi'])->name('reset-password.post');

// Rute grup untuk role Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
});

// Rute grup untuk role Karyawan
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('dashboard');
    Route::get('/tambah-barang', [TambahbarangController::class, 'index'])->name('tambahbarang');
    Route::post('/tambah-barang', [TambahbarangController::class, 'store'])->name('tambahbarang.store');
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('databarang');
    Route::get('/barang/{id}/edit', [EditBarangController::class, 'edit'])->name('editbarang');
    Route::put('/barang/{id}', [EditBarangController::class, 'update'])->name('updatebarang');
    Route::delete('/barang/{id}', [EditBarangController::class, 'destroy'])->name('deletebarang');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::get('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');
});