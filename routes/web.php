<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ReportController;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu routes (Admin & Waiter)
    Route::resource('menu', MenuController::class);

    // Pelanggan routes (Admin & Waiter)
    Route::resource('pelanggan', PelangganController::class);

    // Pesanan routes (Waiter only)
    Route::resource('pesanan', PesananController::class);
    Route::get('pesanan/group/{idpelanggan}', [PesananController::class, 'group'])->name('pesanan.group');
    Route::get('pesanan/group/{idpelanggan}/{tanggal}', [PesananController::class, 'group'])->name('pesanan.group.date');

    // Transaksi routes (Cashier only)
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/{transaksi}/receipt', [TransaksiController::class, 'receipt'])
        ->name('transaksi.receipt');

    // Meja routes (Admin only)
    Route::resource('meja', MejaController::class);

    // Report routes (Waiter, Cashier, Owner)
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [ReportController::class, 'generate'])->name('laporan.generate');
    Route::post('/laporan/pdf', [ReportController::class, 'generatePdf'])->name('laporan.pdf');
});
