<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaPengaduanController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

// Login dan registrasi: hanya bisa dibuka kalau belum login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Registrasi mandiri hanya untuk customer
    Route::get('register', [AuthController::class, 'formRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Halaman awal: diarahkan sesuai role
Route::get('/', function () {
    $user = auth()->user();

    return $user->isCustomer()
        ? redirect()->route('pengaduan.index')
        : redirect()->route($user->halamanAwal());
})->middleware('auth')->name('home');

// ---------- CUSTOMER ----------
// Melihat, menambah, dan melihat detail pengaduan
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::resource('pengaduan', PengaduanController::class)
        ->only(['index', 'create', 'store', 'show']);
});

// ---------- ADMIN dan PETUGAS ----------
// Keduanya mengelola pengaduan dan data customer. Rutenya dibuat dua kali dengan awalan berbeda:
// admin/...   (nama rute admin.*)
// petugas/... (nama rute petugas.*)
foreach (['admin', 'petugas'] as $role) {
    Route::middleware(['auth', 'role:' . $role])->prefix($role)->name($role . '.')->group(function () {
        // Kelola pengaduan: lihat, tanggapi (ubah status), dan hapus
        Route::resource('pengaduan', KelolaPengaduanController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        // Kelola customer: CRUD
        Route::resource('customer', CustomerController::class)->except('show');
    });
}

// ---------- KHUSUS ADMIN ----------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kelola petugas: CRUD
    Route::resource('petugas', PetugasController::class)->except('show');
});

// Menampilkan foto bukti (harus login)
Route::get('lampiran/{lampiran}', [LampiranController::class, 'tampil'])
    ->middleware('auth')
    ->name('lampiran.tampil');

// Kelola kategori (hanya admin dan petugas, akses lewat URL /kategori)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
});
