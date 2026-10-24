<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasPengaduanController;
use Illuminate\Support\Facades\Route;

// Login dan registrasi: hanya bisa dibuka kalau belum login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'formRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Sisi customer: harus login dulu, kalau belum akan diarahkan ke halaman login
Route::middleware('auth')->group(function () {
    // Halaman awal langsung masuk ke daftar pengaduan
    Route::get('/', fn () => redirect()->route('pengaduan.index'))->name('home');

    // Melihat, menambah, dan melihat detail pengaduan
    Route::resource('pengaduan', PengaduanController::class)
        ->only(['index', 'create', 'store', 'show']);
});

// Sisi petugas: menanggapi, mengubah status, dan menghapus pengaduan (tanpa login, akses lewat URL)
Route::resource('petugas/pengaduan', PetugasPengaduanController::class)
    ->names('petugas.pengaduan')
    ->only(['index', 'show', 'update', 'destroy']);

// Menampilkan foto bukti
Route::get('lampiran/{lampiran}', [LampiranController::class, 'tampil'])->name('lampiran.tampil');

// Kelola kategori (tanpa login, akses lewat URL)
Route::resource('kategori', KategoriController::class)->except('show');
