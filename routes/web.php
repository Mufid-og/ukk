<?php

use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PetugasTransaksiController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC (USER) ====================
Route::get('/', [LandingController::class, 'index'])->name('landing');

// ==================== AUTH ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== USER (AUTH) ====================
Route::middleware('auth')->group(function () {
    Route::get('/booking/{car}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{car}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');
});

// ==================== PETUGAS (MOBILE) ====================
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/', [PetugasTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/baru', [PetugasTransaksiController::class, 'create'])->name('transaksi.form');
    Route::post('/transaksi', [PetugasTransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/{transaksie}/verifikasi', [PetugasTransaksiController::class, 'verify'])->name('transaksi.verifikasi');
    Route::post('/transaksi/{transaksie}/selesai', [PetugasTransaksiController::class, 'finish'])->name('transaksi.selesai');
});

// ==================== ADMIN ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index-dashboard');

    Route::prefix('/kelola-mobil')->group(function () {
        Route::get('/', [MobilController::class, 'index'])->name('index-kelola-mobil');
        Route::get('/tambah', [MobilController::class, 'create'])->name('index-kelola-mobil-create');
        Route::get('/detail/{id}', [MobilController::class, 'indexMobilDetail'])->name('index-kelola-mobil-detail');
        Route::post('/kelas', [MobilController::class, 'postKelas'])->name('post-kelas');
        Route::post('/brand', [MobilController::class, 'postBrand'])->name('post-brand');
        Route::post('/car', [MobilController::class, 'storeCar'])->name('post-car');
        Route::put('/car', [MobilController::class, 'putCar'])->name('put-car');
        Route::delete('/kelas/{id}', [MobilController::class, 'deleteKelas'])->name('delete-kelas');
        Route::delete('/brand/{id}', [MobilController::class, 'deleteBrand'])->name('delete-brand');
        Route::delete('/car/{id}', [MobilController::class, 'deleteCar'])->name('delete-car');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
        Route::delete('/transaksi/{transaksie}', [AdminTransaksiController::class, 'destroy'])->name('transaksi.destroy');
        Route::get('/kelola-user', [AdminUserController::class, 'index'])->name('user.index');
        Route::post('/kelola-user', [AdminUserController::class, 'store'])->name('user.store');
        Route::put('/kelola-user/{user}', [AdminUserController::class, 'update'])->name('user.update');
        Route::delete('/kelola-user/{user}', [AdminUserController::class, 'destroy'])->name('user.destroy');
    });
});
