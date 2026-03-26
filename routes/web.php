<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendudukController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Penduduk & Keluarga — semua role bisa akses
    Route::resource('penduduk', PendudukController::class);
    Route::resource('keluarga', KeluargaController::class);
    Route::post('keluarga/{keluarga}/anggota', [KeluargaController::class, 'tambahAnggota'])
        ->name('keluarga.tambah-anggota');
    Route::patch('keluarga/{keluarga}/anggota/{anggota}/keluar', [KeluargaController::class, 'keluarAnggota'])
        ->name('keluarga.keluar-anggota');

    // Manajemen user — hanya superadmin
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)
            ->except(['show']);
    });
});
