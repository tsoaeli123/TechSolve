<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TeacherProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---------------- HOME ----------------
Route::get('/', fn() => view('welcome'))->name('home');

// ---------------- AUTH (GUEST) ----------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// ---------------- PROFILE (AUTH) ----------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------- STUDENT ROUTES ----------------
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', [TestController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/tests/{test}', [TestController::class, 'take'])->name('student.tests.show');
    Route::post('/student/tests/{test}/submit', [TestController::class, 'submit'])->name('student.tests.submit');
});

// ---------------- TEACHER ROUTES ----------------
Route::middleware('auth')->group(function () {
    Route::get('/teacher/dashboard', fn() => view('teacher.dashboard'))->name('teacher.dashboard');

    // Resource routes for tests
    Route::resource('tests', TestController::class);

    // Assign tests
    Route::get('/tests/{test}/assign', [TestController::class, 'assignForm'])->name('tests.assignForm');
    Route::post('/tests/{test}/assign', [TestController::class, 'assign'])->name('tests.assign');

    // Ajax route
    Route::get('/grades/{grade}/students', [TestController::class, 'getStudentsByGrade'])->name('grades.students');
});

// ---------------- ADMIN ROUTES ----------------
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

// Teacher profile routes

Route::get('/teacher/profile', [TeacherProfileController::class, 'showProfile'])->name('teacher.profile');
Route::get('/teacher/profile/edit', [TeacherProfileController::class, 'editProfile'])->name('teacher.profile.edit');
Route::put('/teacher/profile', [TeacherProfileController::class, 'updateProfile'])->name('teacher.profile.update');
Route::delete('/teacher/profile', [TeacherProfileController::class, 'destroyProfile'])->name('teacher.profile.destroy');




// ---------------- DEFAULT AUTH ROUTES ----------------
require __DIR__.'/auth.php';
