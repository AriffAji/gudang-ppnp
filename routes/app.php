<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('barang', BarangController::class);
Route::resource('barang-masuk', BarangMasukController::class);
Route::resource('permintaan', PermintaanController::class);
Route::resource('approval', ApprovalController::class);
