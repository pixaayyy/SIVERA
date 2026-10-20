<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\TambahbarangController;
use App\Http\Controllers\Karyawan\DataBarangController;
use App\Http\Controllers\Karyawan\EditBarangController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;


// Halaman utama langsung mengarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('logout',[AuthenticatedSessionController::class, 'destory'])->named('logout');
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


