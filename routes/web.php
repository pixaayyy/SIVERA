<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\NotifikasiController;

use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\TambahbarangController as KaryawanTambahBarang;
use App\Http\Controllers\Karyawan\DataBarangController as KaryawanDataBarang;
use App\Http\Controllers\Karyawan\EditBarangController as KaryawanEditBarang;
use App\Http\Controllers\Karyawan\MonitoringController as KaryawanMonitoring;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TambahBarangController as AdminTambahBarang;
use App\Http\Controllers\Admin\DataBarangController as AdminDataBarang;
use App\Http\Controllers\Admin\EditBarangController as AdminEditBarang;
use App\Http\Controllers\Admin\DataKaryawanController as AdminDataKaryawan;
use App\Http\Controllers\Admin\TambahKaryawanController as AdminTambahKaryawan;
use App\Http\Controllers\Admin\EditKaryawanController;
use App\Http\Controllers\Admin\MonitoringController as AdminMonitoring;

Route::get('/', function () {
    return redirect()->route('login');
}); 

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/lupa-sandi', [PasswordResetLinkController::class, 'create'])->name('lupa-sandi');
Route::post('/lupa-sandi', [PasswordResetLinkController::class, 'store'])->name('lupa-sandi.post');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::get('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');
});

Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('dashboard');
    Route::get('/tambah-barang', [KaryawanTambahBarang::class, 'index'])->name('tambahbarang');
    Route::post('/tambah-barang', [KaryawanTambahBarang::class, 'store'])->name('tambahbarang.store');
    Route::get('/data-barang', [KaryawanDataBarang::class, 'index'])->name('databarang');
    Route::get('/barang/{id}/edit', [KaryawanEditBarang::class, 'edit'])->name('editbarang');
    Route::put('/barang/{id}', [KaryawanEditBarang::class, 'update'])->name('updatebarang');
    Route::delete('/barang/{id}', [KaryawanEditBarang::class, 'destroy'])->name('deletebarang');
    Route::get('/monitoring', [KaryawanMonitoring::class, 'index'])->name('monitoring');
    Route::get('/monitoring/export-pdf', [KaryawanMonitoring::class, 'exportPdf'])->name('monitoring.pdf');
    Route::get('/monitoring/export-excel', [KaryawanMonitoring::class, 'exportExcel'])->name('monitoring.excel');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/tambah-barang', [AdminTambahBarang::class, 'index'])->name('tambahbarang');
    Route::post('/tambah-barang', [AdminTambahBarang::class, 'store'])->name('tambahbarang.store');
    Route::get('/data-barang', [AdminDataBarang::class, 'index'])->name('databarang');
    Route::get('/barang/{id}/edit', [AdminEditBarang::class, 'edit'])->name('editbarang');
    Route::put('/barang/{id}', [AdminEditBarang::class, 'update'])->name('updatebarang');
    Route::delete('/barang/{id}', [AdminEditBarang::class, 'destroy'])->name('deletebarang');
    Route::post('/kategori/store', [AdminDataBarang::class, 'storeKategori'])->name('kategori.store');
    Route::delete('/kategori/{id}', [App\Http\Controllers\Admin\DataBarangController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::get('/data-karyawan', [AdminDataKaryawan::class, 'index'])->name('datakaryawan');
    Route::get('/karyawan/tambah', [AdminTambahKaryawan::class, 'create'])->name('karyawan.tambah');
    Route::post('/karyawan/simpan', [AdminTambahKaryawan::class, 'store'])->name('karyawan.simpan');
    Route::get('/karyawan/edit/{id}', [EditKaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/update/{id}', [EditKaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/hapus/{id}', [EditKaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::get('/monitoring', [AdminMonitoring::class, 'index'])->name('monitoring');
    Route::get('/monitoring/export-pdf', [AdminMonitoring::class, 'exportPdf'])->name('monitoring.pdf');
    Route::get('/monitoring/export-excel', [AdminMonitoring::class, 'exportExcel'])->name('monitoring.excel');

});
