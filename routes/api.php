<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\TrackingApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\InvoiceApiController;

// PUBLIC
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

Route::get('/track/{vin}', [TrackingApiController::class, 'show']);

// PROTECTED USER
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::get('/dashboard', [DashboardApiController::class, 'index']);
    Route::get('/history', [DashboardApiController::class, 'history']);

    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/bookings', [BookingApiController::class, 'index']);

    Route::get('/invoice/{id}', [InvoiceApiController::class, 'show']);
});