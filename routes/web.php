<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/reviews', [HomeController::class, 'storeReview'])->name('reviews.store');
Route::post('/search', [HomeController::class, 'searchCars'])->name('search.cars');

// Car routes
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/available', [CarController::class, 'available'])->name('cars.available');
Route::get('/cars/filter', [CarController::class, 'filter'])->name('cars.filter');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{car}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/{car}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Car management routes
    Route::resource('cars', App\Http\Controllers\Admin\CarController::class);
});

// Public routes
Route::get('/cars/available', [App\Http\Controllers\CarController::class, 'available'])->name('cars.available');
Route::get('/cars/{car}', [App\Http\Controllers\CarController::class, 'show'])->name('cars.show');
