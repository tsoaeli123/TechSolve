<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Add to routes/web.php for testing
Route::post('/test-pdf-upload', function(Request $request) {
    try {
        if ($request->hasFile('marked_paper')) {
            $file = $request->file('marked_paper');
            $path = $file->storeAs('test_uploads', 'test_' . time() . '.pdf', 'public');

            return response()->json([
                'success' => true,
                'path' => $path,
                'exists' => Storage::disk('public')->exists($path),
                'url' => Storage::disk('public')->url($path),
                'size' => Storage::disk('public')->size($path)
            ]);
        }
        return response()->json(['success' => false, 'message' => 'No file']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});
// Student report routes
Route::get('/student/report', [TestController::class, 'studentReport'])->name('student.report');
Route::get('/student/report/download', [TestController::class, 'downloadStudentReport'])->name('student.report.download');
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
    Route::get('/student/results', [TestController::class, 'results'])->name('student.results'); // ADDED THIS ROUTE
    Route::get('/student/tests/{test}', [TestController::class, 'take'])->name('student.tests.show');
    Route::post('/student/tests/{test}/submit', [TestController::class, 'submit'])->name('student.tests.submit');

    // Student PDF viewing route
    Route::get('/student/tests/{test}/view-pdf', [TestController::class, 'viewStudentPdf'])->name('student.tests.view-pdf');

    // Student PDF answer submission route
    Route::post('/student/tests/{test}/submit-pdf', [TestController::class, 'submitPdfAnswer'])->name('student.tests.submit-pdf');
});

// ---------------- TEACHER ROUTES ----------------
Route::middleware('auth')->group(function () {
    Route::get('/teacher/dashboard', fn() => view('teacher.dashboard'))->name('teacher.dashboard');

    // Resource routes for tests
    Route::resource('tests', TestController::class);

    // PDF routes for teachers
    Route::get('/tests/{test}/pdf', [TestController::class, 'viewPdf'])->name('tests.view.pdf');
    Route::get('/tests/{test}/download-pdf', [TestController::class, 'downloadPdf'])->name('tests.download.pdf');
    Route::get('/answers/{answer}/download-pdf', [TestController::class, 'downloadAnswerPdf'])->name('answers.download.pdf');
    Route::get('/answers/{answer}/view-pdf', [TestController::class, 'viewAnswerPdf'])->name('answers.view.pdf');

    // Teacher PDF management routes
    Route::post('/tests/{test}/replace-pdf', [TestController::class, 'replacePdf'])->name('tests.replace.pdf');
    Route::delete('/tests/{test}/remove-pdf', [TestController::class, 'removePdf'])->name('tests.remove.pdf');

    // Teacher student answer PDF viewing routes
    Route::get('/teacher/tests/{test}/answers/{answerId}/view-pdf', [TestController::class, 'viewStudentAnswerPdf'])->name('teacher.tests.answers.view-pdf');
    Route::get('/teacher/tests/{test}/answers/{answerId}/download-pdf', [TestController::class, 'downloadStudentAnswerPdf'])->name('teacher.tests.answers.download-pdf');

    // Ajax route
    Route::get('/grades/{grade}/students', [TestController::class, 'getStudentsByGrade'])->name('grades.students');
});

// Announcements Post
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

// ---------------- ADD ONLY THIS NEW ROUTE FOR GRADING ----------------
Route::post('/tests/{test}/submissions/{studentId}/grade', [TestController::class, 'gradeSubmissions'])->name('submissions.grade');

// ---------------- ADMIN ROUTES ----------------
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

// Teacher profile routes
Route::get('/teacher/profile', [TeacherProfileController::class, 'showProfile'])->name('teacher.profile');
Route::get('/teacher/profile/edit', [TeacherProfileController::class, 'editProfile'])->name('teacher.profile.edit');
Route::put('/teacher/profile', [TeacherProfileController::class, 'updateProfile'])->name('teacher.profile.update');
Route::delete('/teacher/profile', [TeacherProfileController::class, 'destroyProfile'])->name('teacher.profile.destroy');

// ---------------- DEBUG ROUTES ----------------
Route::get('/debug/check-storage', function() {
    echo "<h2>Storage Debug Information</h2>";

    // Check storage directory
    $studentAnswersPath = storage_path('app/public/student_answers');
    echo "Student Answers Path: " . $studentAnswersPath . "<br>";
    echo "Directory exists: " . (file_exists($studentAnswersPath) ? 'YES' : 'NO') . "<br>";

    if (file_exists($studentAnswersPath)) {
        $files = scandir($studentAnswersPath);
        echo "Files in student_answers:<br>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $studentAnswersPath . '/' . $file;
                echo "- " . $file . " (" . filesize($filePath) . " bytes, " . date('Y-m-d H:i:s', filemtime($filePath)) . ")<br>";
            }
        }
    }

    // Check specific file from database
    echo "<h3>Database PDF Records:</h3>";
    $pdfAnswers = \App\Models\TestAnswer::where('answer', 'PDF_SUBMISSION')
        ->whereNotNull('answer_pdf_path')
        ->get();

    foreach ($pdfAnswers as $answer) {
        echo "Answer ID: " . $answer->id . "<br>";
        echo "PDF Path: " . $answer->answer_pdf_path . "<br>";
        echo "Original Name: " . $answer->answer_pdf_original_name . "<br>";

        $fullPath = storage_path('app/public/' . $answer->answer_pdf_path);
        echo "Full Path: " . $fullPath . "<br>";
        echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "<br>";

        if (file_exists($fullPath)) {
            echo "File size: " . filesize($fullPath) . " bytes<br>";
            echo "Storage URL: " . \Storage::disk('public')->url($answer->answer_pdf_path) . "<br>";

            // Try to create a direct link
            echo "<a href='" . \Storage::disk('public')->url($answer->answer_pdf_path) . "' target='_blank'>Open PDF Directly</a><br>";
        }
        echo "<hr>";
    }

    return "Debug complete";
});

Route::get('/debug/fix-pdf-storage', function() {
    // Create storage directory if it doesn't exist
    $studentAnswersPath = storage_path('app/public/student_answers');
    if (!file_exists($studentAnswersPath)) {
        mkdir($studentAnswersPath, 0755, true);
        echo "Created directory: " . $studentAnswersPath . "<br>";
    }

    // Re-run storage link
    \Artisan::call('storage:link');
    echo "Storage link refreshed<br>";

    return "Storage fix attempted";
});

Route::get('/debug/pdf-submission/{testId}', function($testId) {
    $test = \App\Models\Test::find($testId);
    $studentId = Auth::id();

    echo "<h2>PDF Submission Debug</h2>";
    echo "Test ID: " . $testId . "<br>";
    echo "Student ID: " . $studentId . "<br>";
    echo "Test Has PDF: " . ($test->has_pdf ? 'Yes' : 'No') . "<br>";

    // Check existing submissions
    $existing = \App\Models\TestAnswer::where('test_id', $testId)
        ->where('student_id', $studentId)
        ->first();

    echo "Existing Submission: " . ($existing ? 'Yes' : 'No') . "<br>";
    if ($existing) {
        echo "PDF Path: " . ($existing->answer_pdf_path ?? 'NULL') . "<br>";
        echo "PDF Original Name: " . ($existing->answer_pdf_original_name ?? 'NULL') . "<br>";
    }

    // Check storage directory
    echo "<h3>Storage Check</h3>";
    $files = \Storage::disk('public')->files('student_answers');
    echo "Files in student_answers: " . count($files) . "<br>";
    foreach ($files as $file) {
        echo "- " . $file . " (" . \Storage::disk('public')->size($file) . " bytes)<br>";
    }

    return "<br>Debug complete";
})->middleware('auth');

Route::get('/debug/check-pdf-answer/{answerId}', function($answerId) {
    $answer = \App\Models\TestAnswer::find($answerId);

    if (!$answer) {
        return "Answer not found";
    }

    echo "<h2>PDF Answer Debug - ID: {$answerId}</h2>";
    echo "Test ID: " . $answer->test_id . "<br>";
    echo "Student ID: " . $answer->student_id . "<br>";
    echo "Answer Type: " . $answer->answer . "<br>";
    echo "PDF Path: " . ($answer->answer_pdf_path ?? 'NULL') . "<br>";
    echo "PDF Original Name: " . ($answer->answer_pdf_original_name ?? 'NULL') . "<br>";

    if ($answer->answer_pdf_path) {
        // Check storage
        $exists = Storage::disk('public')->exists($answer->answer_pdf_path);
        echo "Storage Exists: " . ($exists ? 'YES' : 'NO') . "<br>";

        if ($exists) {
            echo "File Size: " . Storage::disk('public')->size($answer->answer_pdf_path) . " bytes<br>";
            echo "Storage URL: " . Storage::disk('public')->url($answer->answer_pdf_path) . "<br>";

            // Try to show the PDF
            echo "<h3>PDF Preview:</h3>";
            echo "<iframe src='" . Storage::disk('public')->url($answer->answer_pdf_path) . "' width='100%' height='600px'></iframe>";
        } else {
            echo "<p style='color: red;'>File not found in storage!</p>";

            // Check what files exist
            echo "<h3>Files in student_answers directory:</h3>";
            $files = Storage::disk('public')->files('student_answers');
            if (count($files) > 0) {
                foreach ($files as $file) {
                    echo "- " . $file . " (" . Storage::disk('public')->size($file) . " bytes)<br>";
                }
            } else {
                echo "No files found in student_answers directory<br>";
            }
        }
    }

    return "<br>Debug complete";
})->middleware('auth');

Route::get('/debug/pdf-storage', function() {
    echo "<h3>PDF Storage Debug</h3>";

    // Check recent PDF tests
    $pdfTests = \App\Models\Test::where('has_pdf', true)
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();

    foreach ($pdfTests as $test) {
        echo "<h4>Test: {$test->title} (ID: {$test->id})</h4>";
        echo "PDF Path: " . $test->pdf_path . "<br>";
        echo "Original Name: " . $test->pdf_original_name . "<br>";

        if ($test->pdf_path) {
            $exists = Storage::disk('public')->exists($test->pdf_path);
            echo "File Exists: " . ($exists ? 'Yes' : 'No') . "<br>";

            if ($exists) {
                echo "File Size: " . Storage::disk('public')->size($test->pdf_path) . " bytes<br>";
                echo "Storage URL: " . Storage::disk('public')->url($test->pdf_path) . "<br>";
            }
        }
        echo "<hr>";
    }

    return "Debug complete";
});

// Debug route to check specific PDF
Route::get('/debug/check-pdf/{testId}', function($testId) {
    $test = \App\Models\Test::find($testId);

    if (!$test) {
        return "Test not found";
    }

    echo "<h2>PDF Debug for Test: {$test->title}</h2>";
    echo "Has PDF: " . ($test->has_pdf ? 'Yes' : 'No') . "<br>";
    echo "PDF Path: " . ($test->pdf_path ?? 'NULL') . "<br>";
    echo "PDF Original Name: " . ($test->pdf_original_name ?? 'NULL') . "<br>";

    if ($test->pdf_path) {
        $exists = Storage::disk('public')->exists($test->pdf_path);
        echo "File Exists: " . ($exists ? 'Yes' : 'No') . "<br>";

        if ($exists) {
            echo "File Size: " . Storage::disk('public')->size($test->pdf_path) . " bytes<br>";
            echo "Storage URL: " . Storage::disk('public')->url($test->pdf_path) . "<br>";

            // Try to show the PDF
            echo "<h3>PDF Preview:</h3>";
            echo "<iframe src='" . Storage::disk('public')->url($test->pdf_path) . "' width='100%' height='600px'></iframe>";
        } else {
            echo "<p style='color: red;'>PDF file not found in storage!</p>";
            echo "Looking for: storage/app/public/" . $test->pdf_path . "<br>";

            // Check what files exist in question_pdfs directory
            echo "<h3>Files in question_pdfs directory:</h3>";
            $files = Storage::disk('public')->files('question_pdfs');
            if (count($files) > 0) {
                foreach ($files as $file) {
                    echo "- " . $file . " (" . Storage::disk('public')->size($file) . " bytes)<br>";
                }
            } else {
                echo "No files found in question_pdfs directory<br>";
            }
        }
    }

    return "<br>Debug complete";
});
// Add these routes in the TEACHER ROUTES section or STUDENT ROUTES section:

// Student PDF viewing routes for marked answers
Route::get('/student/answers/{answer}/view-marked-pdf', [TestController::class, 'viewStudentMarkedPdf'])->name('student.answers.view-marked-pdf');
Route::get('/student/answers/{answer}/download-marked-pdf', [TestController::class, 'downloadStudentMarkedPdf'])->name('student.answers.download-marked-pdf');

// Teacher PDF viewing routes for marked answers
Route::get('/teacher/answers/{answer}/view-marked-pdf', [TestController::class, 'viewTeacherMarkedPdf'])->name('teacher.answers.view-marked-pdf');
Route::get('/teacher/answers/{answer}/download-marked-pdf', [TestController::class, 'downloadTeacherMarkedPdf'])->name('teacher.answers.download-marked-pdf');

// Test PDF upload route
Route::get('/test-pdf-upload', function() {
    return view('test-pdf-upload');
});

Route::post('/test-pdf-upload', function(Illuminate\Http\Request $request) {
    if ($request->hasFile('test_pdf')) {
        $file = $request->file('test_pdf');

        try {
            $path = $file->storeAs('question_pdfs', 'test_' . time() . '.pdf', 'public');
            return "File uploaded successfully: " . $path . "<br>File exists: " . (Storage::disk('public')->exists($path) ? 'Yes' : 'No');
        } catch (\Exception $e) {
            return "Upload failed: " . $e->getMessage();
        }
    }
    return "No file uploaded";
});

// ---------------- DEFAULT AUTH ROUTES ----------------
require __DIR__.'/auth.php';
