<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminInvoiceController;

// ── Public ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [App\Http\Controllers\ServicePageController::class, 'index'])->name('services');
Route::get('/track', [TrackingController::class, 'index'])->name('track');
Route::get('/track/{vin}', [TrackingController::class, 'show'])->name('track.show');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// ── Auth User ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
    Route::get('/admin/login',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Protected — User ─────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/history',   [HistoryController::class, 'index'])->name('history');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
});

// ── Protected — Admin ─────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings',              [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}',         [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/update', [AdminBookingController::class, 'update'])->name('bookings.update');

    // ← BARU: update status pembayaran faktur
    Route::post('/invoice/{id}/payment', [AdminInvoiceController::class, 'updatePayment'])->name('invoice.payment');
});