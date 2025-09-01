<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', fn() => view('welcome'))->name('home');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registration
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Auth routes (login, logout, password reset)
require __DIR__.'/auth.php';

// Role-based dashboards
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
        ->name('admin.dashboard');

    // Teacher dashboard
    Route::get('/teacher/dashboard', fn() => view('teacher.dashboard'))
        ->name('teacher.dashboard');

    // Student dashboard
    Route::get('/student/dashboard', fn() => view('student.dashboard'))
        ->name('student.dashboard');
});
