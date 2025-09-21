<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\AnnouncementsController;

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




    // Ajax route
    Route::get('/grades/{grade}/students', [TestController::class, 'getStudentsByGrade'])->name('grades.students');
});


//Announcements Post
  Route::get('/teacher/announcements',  [AnnouncementsController::class, 'index'])->name('teacher.announcements');
  Route::post('/teacher/announcement', [AnnouncementsController::class, 'store'])->name('teacher.announcement');
  Route::delete('/announcement/{id}', [AnnouncementsController::class, 'destroy'])->name('teacher.destroy');
  



 // Assign tests
Route::get('/tests/{id}/assign-form', [TestController::class, 'assignForm'])->name('tests.assign.form');
Route::post('/tests/{id}/assign', [TestController::class, 'assignStore'])->name('tests.assign.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/tests/{test}/submissions', [TestController::class, 'viewSubmissions'])
        ->name('tests.submissions');
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
