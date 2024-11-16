<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnkripsiTextController;

// Route to show page Auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/enkripsi-text', [EnkripsiTextController::class, 'showForm'])->name('enkripsi-text.form');
    Route::post('/enkripsi-text', [EnkripsiTextController::class, 'process'])->name('enkripsi-text.process');
});
