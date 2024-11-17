<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnkripsiFileController;
use App\Http\Controllers\EnkripsiTextController;
use App\Http\Controllers\SteganographyController;

// Route to show page Auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/enkripsi-text', [EnkripsiTextController::class, 'showFormEnkripsi'])->name('enkripsi-text.form');
    Route::post('/enkripsi-text', [EnkripsiTextController::class, 'processEnkripsi'])->name('enkripsi-text.process');

    Route::get('/dekripsi-text', [EnkripsiTextController::class, 'showFormDekripsi'])->name('dekripsi-text.form');
    Route::post('/dekripsi-text', [EnkripsiTextController::class, 'processDekripsi'])->name('dekripsi-text.process');

    Route::get('/enkripsi-file', [EnkripsiFileController::class, 'showFormEnkripsi'])->name('enkripsi-file.form');
    Route::post('/enkripsi-file', [EnkripsiFileController::class, 'processEnkripsi'])->name('enkripsi-file.process');

    Route::get('/dekripsi-file', [EnkripsiFileController::class, 'showFormDekripsi'])->name('dekripsi-file.form');
    Route::post('/dekripsi-file', [EnkripsiFileController::class, 'processDekripsi'])->name('dekripsi-file.process');

    Route::get('/steganography/hide', [SteganographyController::class, 'showFormHide'])->name('enkripsi-image');
    Route::post('/steganography/hide', [SteganographyController::class, 'hideMessage'])->name('steganography.hide.process');

    Route::get('/steganography/extract', [SteganographyController::class, 'showFormExtract'])->name('dekripsi-image');
    Route::post('/steganography/extract', [SteganographyController::class, 'extractMessage'])->name('steganography.extract.process');

    Route::get('/download/{id}', [DashboardController::class, 'download'])->name('download');
});
