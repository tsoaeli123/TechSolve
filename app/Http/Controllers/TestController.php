<?php
// app/Http/Controllers/TestController.php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Subject;
use App\Models\TestAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ---------------- TEACHER SIDE ---------------- //

    public function index()
    {
        $this->authorizeTeacher();

        $tests = Test::where('teacher_id', Auth::id())->with('subject')->get();

        $classGrades = User::where('role', 'student')
            ->whereNotNull('class_grade')
            ->distinct()
            ->pluck('class_grade');

        return view('tests.index', compact('tests', 'classGrades'));
    }

    public function create()
    {
        $this->authorizeTeacher();

        $subjects = Subject::all();
        return view('tests.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $this->authorizeTeacher();

        if ($request->question_type === 'pdf') {
            $request->validate([
                'title' => 'required|string|max:255',
                'subject_id' => 'required|exists:subjects,id',
                'scheduled_at' => 'required|date',
                'question_pdf' => 'required|file|mimes:pdf|max:10240',
            ]);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'subject_id' => 'required|exists:subjects,id',
                'scheduled_at' => 'required|date',
                'questions' => 'required|array|min:1',
                'questions.*.text' => 'required',
                'questions.*.type' => 'required|in:mcq,written',
                'questions.*.options' => 'required_if:questions.*.type,mcq|nullable|string',
                'questions.*.correct_answer' => 'required_if:questions.*.type,mcq|nullable|integer',
                'questions.*.marks' => 'required|integer|min:1',
            ]);
        }

        $test = Test::create([
            'title'       => $request->title,
            'subject_id'  => $request->subject_id,
            'scheduled_at' => Carbon::parse($request->scheduled_at),
            'teacher_id'  => Auth::id(),
            'question_type' => $request->question_type,
        ]);

        if ($request->question_type === 'pdf' && $request->hasFile('question_pdf')) {
            $pdfFile = $request->file('question_pdf');
            $pdfPath = $pdfFile->store('test_pdfs', 'public');

            $test->update([
                'has_pdf' => true,
                'pdf_path' => $pdfPath,
                'pdf_original_name' => $pdfFile->getClientOriginalName(),
            ]);
        }
        else if ($request->question_type === 'manual') {
            foreach ($request->questions as $index => $q) {
                $optionsArray = null;
                $correctAnswer = null;

                if ($q['type'] === 'mcq') {
                    $optionsArray = !empty($q['options'])
                        ? array_map('trim', explode(',', $q['options']))
                        : null;

                    $correctAnswer = isset($q['correct_answer'])
                        ? (int)$q['correct_answer']
                        : null;
                }

                $test->questions()->create([
                    'question_text'  => $q['text'],
                    'type'           => $q['type'],
                    'marks'          => $q['marks'] ?? 1,
                    'options'        => $optionsArray ? json_encode($optionsArray) : null,
                    'correct_answer' => $correctAnswer,
                    'contains_math'  => true,
                ]);
            }
        }

        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }

    public function viewSubmissions(Test $test)
    {
        $this->authorizeTeacher();

        $submissions = TestAnswer::where('test_id', $test->id)
            ->with(['student', 'question'])
            ->get()
            ->groupBy('student_id');

        return view('tests.submissions', compact('test', 'submissions'));
    }

    /**
     * Grade student submissions - FIXED METHOD
     */
   public function gradeSubmissions(Request $request, Test $test, $studentId)
{
    $this->authorizeTeacher();

    $request->validate([
        'marks' => 'required|array',
        'marks.*' => 'nullable|numeric|min:0',
        'comments' => 'sometimes|array',
        'marked_paper' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    try {
        DB::beginTransaction();

        \Log::info("=== START GRADING - SIMPLIFIED ===");
        \Log::info("Test ID: " . $test->id);
        \Log::info("Student ID: " . $studentId);

        $answers = TestAnswer::where('test_id', $test->id)
            ->where('student_id', $studentId)
            ->get();

        \Log::info("Found answers to grade: " . $answers->count());

        $totalMarks = 0;
        $markedPdfPath = null;
        $markedPdfOriginalName = null;

        // Handle marked PDF upload - SIMPLIFIED like submitPdfAnswer
        if ($request->hasFile('marked_paper')) {
            $markedPdf = $request->file('marked_paper');
            \Log::info("Marked PDF file detected", [
                'original_name' => $markedPdf->getClientOriginalName(),
                'size' => $markedPdf->getSize()
            ]);

            // Use the EXACT same pattern as submitPdfAnswer
            $filename = 'marked_answer_' . $test->id . '_' . $studentId . '_' . time() . '.pdf';
            $markedPdfPath = $markedPdf->storeAs('marked_answers', $filename, 'public');
            $markedPdfOriginalName = $markedPdf->getClientOriginalName();

            \Log::info("Marked PDF stored at: " . $markedPdfPath);
            \Log::info("File exists check: " . (Storage::disk('public')->exists($markedPdfPath) ? 'YES' : 'NO'));
        }

        // Process each answer - SIMPLIFIED update approach
        foreach ($answers as $answer) {
            $mark = $request->marks[$answer->id] ?? null;
            $comment = $request->comments[$answer->id] ?? null;

            // Build update data - SIMPLE and DIRECT
            $updateData = [
                'marked_at' => now(),
                'marked_by' => Auth::id(),
                'marking_status' => 'completed',
                'updated_at' => now(), // Explicitly set updated_at
            ];

            if ($mark !== null) {
                $updateData['marks'] = $mark;
                $updateData['score'] = $mark;
                $totalMarks += $mark;
            }

            if ($comment !== null) {
                $updateData['comments'] = $comment;
            }

            // CRITICAL: Always set PDF data if we have it
            if ($markedPdfPath) {
                $updateData['marked_pdf_path'] = $markedPdfPath;
                $updateData['marked_pdf_original_name'] = $markedPdfOriginalName;
                \Log::info("Setting PDF data for answer ID: " . $answer->id);
            }

            // Use direct SQL update to avoid Eloquent issues
            DB::table('test_answers')
                ->where('id', $answer->id)
                ->update($updateData);

            \Log::info("Updated answer ID: " . $answer->id . " with marks: " . ($mark ?? 'NULL'));
        }

        DB::commit();

        \Log::info("=== GRADING COMPLETED ===");
        \Log::info("Total marks: " . $totalMarks);
        \Log::info("Marked PDF path: " . ($markedPdfPath ?? 'NULL'));

        // Verify the update worked
        $updatedAnswers = TestAnswer::where('test_id', $test->id)
            ->where('student_id', $studentId)
            ->get();

        foreach ($updatedAnswers as $updatedAnswer) {
            \Log::info("After update - Answer ID: " . $updatedAnswer->id .
                      ", Marked PDF: " . ($updatedAnswer->marked_pdf_path ?? 'NULL') .
                      ", Marks: " . ($updatedAnswer->marks ?? 'NULL'));
        }

        $successMessage = 'Marks and feedback submitted successfully!';
        if ($markedPdfPath) {
            $successMessage .= ' Marked PDF uploaded.';
        }

        return redirect()->route('tests.submissions', $test->id)
            ->with('success', $successMessage);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('GRADING ERROR: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());

        return redirect()->back()
            ->with('error', 'Failed to submit marks and feedback: ' . $e->getMessage());
    }
}
    public function assignStore(Request $request, $id)
    {
        $request->validate([
            'class_grade' => 'required|string'
        ]);

        DB::table('assigned_tests')->insert([
            'test_id' => $id,
            'class_grade' => $request->class_grade,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tests.index')->with('success', 'Test assigned successfully!');
    }

    public function show(Test $test)
    {
        $this->authorizeTeacher();

        $test->load('questions', 'subject');
        return view('tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $this->authorizeTeacher();

        $subjects = Subject::all();
        return view('tests.edit', compact('test', 'subjects'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorizeTeacher();

        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'scheduled_at' => 'required|date',
        ]);

        $test->update([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'scheduled_at' => Carbon::parse($request->scheduled_at),
        ]);

        return redirect()->route('tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $this->authorizeTeacher();

        if ($test->pdf_path && Storage::disk('public')->exists($test->pdf_path)) {
            Storage::disk('public')->delete($test->pdf_path);
        }

        $test->delete();

        return redirect()->route('tests.index')->with('success', 'Test deleted successfully.');
    }

    // ---------------- STUDENT SIDE ---------------- //

    public function dashboard()
    {
        $this->authorizeStudent();

        $studentClass = Auth::user()->class_grade;

        $tests = Test::whereHas('assignedTests', function($query) use ($studentClass) {
            $query->where('class_grade', $studentClass);
        })->with('subject')->get();

        // Calculate stats for dashboard - FIXED QUERIES
        $completedTests = TestAnswer::where('student_id', Auth::id())
            ->where('marking_status', 'completed')
            ->distinct('test_id')
            ->count('test_id');

        $pendingTests = $tests->count() - $completedTests;

        // Calculate average score
        $averageScore = TestAnswer::where('student_id', Auth::id())
            ->where('marking_status', 'completed')
            ->whereNotNull('marks')
            ->avg('marks');

        // Format average score
        $averageScore = $averageScore ? number_format($averageScore, 1) : 'N/A';

        // Get recent results for display - FIXED QUERY
        $recentResults = TestAnswer::where('student_id', Auth::id())
            ->where('marking_status', 'completed')
            ->whereNotNull('marks')
            ->with(['test.subject', 'question'])
            ->orderBy('marked_at', 'desc')
            ->get()
            ->groupBy('test_id')
            ->take(3);

        return view('student.dashboard', compact(
            'tests',
            'completedTests',
            'pendingTests',
            'averageScore',
            'recentResults'
        ));
    }

    public function results(Request $request)
    {
        $studentId = Auth::id();

        // Get all completed tests for the student
        $completedTests = TestAnswer::where('student_id', $studentId)
            ->where('marking_status', 'completed')
            ->get()
            ->groupBy('test_id');

        // Get all subjects that have completed tests
        $testIds = $completedTests->keys()->toArray();
        $subjects = Subject::whereIn('id', function($query) use ($testIds) {
            $query->select('subject_id')
                ->from('tests')
                ->whereIn('id', $testIds);
        })->get();

        $selectedSubject = null;

        // Check if subject parameter is provided
        if ($request->has('subject')) {
            $subjectId = $request->get('subject');
            $selectedSubject = Subject::find($subjectId);

            if ($selectedSubject) {
                // Filter tests by selected subject
                $completedTests = $completedTests->filter(function($answers) use ($subjectId) {
                    return $answers->first()->test->subject_id == $subjectId;
                });
            }
        }

        return view('student.results', compact(
            'completedTests',
            'subjects',
            'selectedSubject'
        ));
    }

    // Student methods for viewing marked PDFs
    public function viewStudentMarkedPdf($answerId)
    {
        $answer = TestAnswer::findOrFail($answerId);

        // Check if student owns this answer
        if ($answer->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked PDF not found.');
        }

        $path = storage_path('app/public/' . $answer->marked_pdf_path);

        if (!file_exists($path)) {
            abort(404, 'Marked PDF file not found.');
        }

        return response()->file($path);
    }

    public function downloadStudentMarkedPdf($answerId)
    {
        $answer = TestAnswer::findOrFail($answerId);

        // Check if student owns this answer
        if ($answer->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked PDF not found.');
        }

        $path = storage_path('app/public/' . $answer->marked_pdf_path);

        if (!file_exists($path)) {
            abort(404, 'Marked PDF file not found.');
        }

        $filename = $answer->marked_pdf_original_name ?: 'marked_answer.pdf';

        return response()->download($path, $filename);
    }

    // Teacher methods for viewing marked PDFs
    public function viewTeacherMarkedPdf($answerId)
    {
        $answer = TestAnswer::findOrFail($answerId);

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked PDF not found.');
        }

        $path = storage_path('app/public/' . $answer->marked_pdf_path);

        if (!file_exists($path)) {
            abort(404, 'Marked PDF file not found.');
        }

        return response()->file($path);
    }

    public function downloadTeacherMarkedPdf($answerId)
    {
        $answer = TestAnswer::findOrFail($answerId);

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked PDF not found.');
        }

        $path = storage_path('app/public/' . $answer->marked_pdf_path);

        if (!file_exists($path)) {
            abort(404, 'Marked PDF file not found.');
        }

        $filename = $answer->marked_pdf_original_name ?: 'marked_answer.pdf';

        return response()->download($path, $filename);
    }

    public function take(Test $test)
    {
        $this->authorizeStudent();

        $test->load('questions', 'subject');

        // Check if deadline has passed
        $deadlinePassed = $test->scheduled_at && now()->greaterThan($test->scheduled_at);

        if ($deadlinePassed) {
            return redirect()->route('student.dashboard')
                ->with('error', 'The submission deadline has passed. You can no longer take this test.');
        }

        // Get all existing answers for this test and student, keyed by question_id
        $existingAnswers = TestAnswer::where('test_id', $test->id)
            ->where('student_id', Auth::id())
            ->get()
            ->keyBy('question_id');

        return view('student.test', compact('test', 'existingAnswers'));
    }

    public function submit(Request $request, Test $test)
    {
        $this->authorizeStudent();

        // Check if deadline has passed
        if ($test->scheduled_at && now()->greaterThan($test->scheduled_at)) {
            return back()->with('error', 'The submission deadline has passed. You can no longer submit this test.');
        }

        if ($test->has_pdf) {
            return redirect()->back()->with('error', 'This test requires PDF submission. Please use the PDF upload form.');
        }

        $request->validate([
            'answers' => 'required|array',
        ]);

        $studentId = Auth::id();
        $test->load('questions');

        // Delete existing answers for this test and student (to allow resubmission)
        TestAnswer::where('test_id', $test->id)
            ->where('student_id', $studentId)
            ->delete();

        foreach ($request->answers as $questionId => $answer) {
            $question = $test->questions->firstWhere('id', $questionId);

            $score = null;
            $studentAnswer = is_array($answer) ? json_encode($answer) : $answer;

            if ($question && $question->type === 'mcq') {
                $options = json_decode($question->options, true);
                $correctIndex = (int)$question->correct_answer;
                $correctValue = $options[$correctIndex] ?? null;

                $score = ($studentAnswer === $correctValue)
                    ? $question->marks
                    : 0;
            }

            TestAnswer::create([
                'test_id'     => $test->id,
                'student_id'  => $studentId,
                'question_id' => $questionId,
                'answer'      => $studentAnswer,
                'score'       => $score,
                'submitted_at' => now(),
            ]);
        }

        // Handle whiteboard answers
        if ($request->whiteboard_answers) {
            foreach ($request->whiteboard_answers as $questionId => $whiteboardData) {
                // Update the answer with whiteboard data if needed
                $whiteboardAnswer = TestAnswer::where('test_id', $test->id)
                    ->where('student_id', $studentId)
                    ->where('question_id', $questionId)
                    ->first();

                if ($whiteboardAnswer) {
                    $whiteboardAnswer->answer .= "\n\n[Whiteboard Answer Attached Below]\n" . $whiteboardData;
                    $whiteboardAnswer->save();
                }
            }
        }

        return back()->with('success', 'Test submitted successfully!');
    }

    public function submitPdf(Request $request, Test $test)
    {
        $this->authorizeStudent();

        // Check if deadline has passed
        if ($test->scheduled_at && now()->greaterThan($test->scheduled_at)) {
            return back()->with('error', 'The submission deadline has passed. You can no longer submit this test.');
        }

        $request->validate([
            'answer_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $studentId = Auth::id();

        // Delete existing PDF submission for this test and student
        TestAnswer::where('test_id', $test->id)
            ->where('student_id', $studentId)
            ->delete();

        // Handle file upload
        if ($request->hasFile('answer_pdf')) {
            $file = $request->file('answer_pdf');
            $filename = 'answer_' . $test->id . '_' . $studentId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('student_answers', $filename, 'public');

            TestAnswer::create([
                'test_id'     => $test->id,
                'student_id'  => $studentId,
                'answer'      => 'PDF_SUBMISSION',
                'answer_pdf_path' => $path,
                'answer_pdf_original_name' => $file->getClientOriginalName(),
                'submitted_at' => now(),
            ]);
        }

        return back()->with('success', 'PDF submitted successfully!');
    }

    public function submitPdfAnswer(Request $request, Test $test)
    {
        $this->authorizeStudent();

        \Log::info('=== PDF SUBMISSION ATTEMPT ===');
        \Log::info('Test ID: ' . $test->id);
        \Log::info('Student ID: ' . Auth::id());
        \Log::info('Has File: ' . ($request->hasFile('answer_pdf') ? 'YES' : 'NO'));

        if (!$test->has_pdf) {
            return redirect()->back()->with('error', 'This test does not have a PDF question paper.');
        }

        $existingSubmission = TestAnswer::where('test_id', $test->id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            return redirect()->route('student.dashboard')
                ->with('info', 'You have already submitted this test.');
        }

        $request->validate([
            'answer_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $pdfFile = $request->file('answer_pdf');
            $filename = 'answer_' . $test->id . '_' . Auth::id() . '_' . time() . '.pdf';
            $pdfPath = $pdfFile->storeAs('student_answers', $filename, 'public');

            \Log::info('File stored at: ' . $pdfPath);
            \Log::info('File exists: ' . (\Storage::disk('public')->exists($pdfPath) ? 'YES' : 'NO'));

            $answerId = DB::table('test_answers')->insertGetId([
                'test_id' => $test->id,
                'student_id' => Auth::id(),
                'question_id' => null,
                'answer' => 'PDF_SUBMISSION',
                'answer_pdf_path' => $pdfPath,
                'answer_pdf_original_name' => $pdfFile->getClientOriginalName(),
                'submitted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Log::info('Database record created with ID: ' . $answerId);

            return redirect()->route('student.dashboard')->with('success', 'PDF answer submitted successfully!');

        } catch (\Exception $e) {
            \Log::error('PDF SUBMISSION FAILED: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            if (isset($pdfPath) && \Storage::disk('public')->exists($pdfPath)) {
                \Storage::disk('public')->delete($pdfPath);
            }

            return redirect()->back()->with('error', 'Failed to submit PDF. Please try again.');
        }
    }

    // ---------------- STUDENT RESULTS ---------------- //

    /**
     * Student view of marked papers
     */
    public function studentResults()
    {
        $this->authorizeStudent();

        $studentId = Auth::id();

        // Get tests that have been marked - FIXED QUERY
        $markedTests = Test::whereHas('answers', function($query) use ($studentId) {
            $query->where('student_id', $studentId)
                  ->where('marking_status', 'completed')
                  ->whereNotNull('marks');
        })->with(['answers' => function($query) use ($studentId) {
            $query->where('student_id', $studentId)
                  ->where('marking_status', 'completed')
                  ->whereNotNull('marks')
                  ->with('question');
        }, 'subject'])->get();

        return view('student.results', compact('markedTests'));
    }

    /**
     * View marked PDF for student
     */
    public function viewMarkedPdf($answerId)
    {
        $this->authorizeStudent();

        $answer = TestAnswer::where('id', $answerId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked paper not available yet.');
        }

        if (!Storage::disk('public')->exists($answer->marked_pdf_path)) {
            abort(404, 'Marked PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($answer->marked_pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($answer->marked_pdf_original_name ?? 'marked_paper.pdf') . '"'
        ]);
    }

    /**
     * Download marked PDF for student
     */
    public function downloadMarkedPdf($answerId)
    {
        $this->authorizeStudent();

        $answer = TestAnswer::where('id', $answerId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if (!$answer->marked_pdf_path) {
            abort(404, 'Marked paper not available yet.');
        }

        if (!Storage::disk('public')->exists($answer->marked_pdf_path)) {
            abort(404, 'Marked PDF file not found.');
        }

        return Storage::disk('public')->download(
            $answer->marked_pdf_path,
            $answer->marked_pdf_original_name ?? 'marked_paper.pdf'
        );
    }

    // ---------------- PDF VIEWING METHODS ---------------- //

    public function viewStudentPdf(Test $test)
    {
        $this->authorizeStudent();

        if (!$test->has_pdf || !$test->pdf_path) {
            abort(404, 'PDF not available for this test.');
        }

        if (!Storage::disk('public')->exists($test->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        if (request()->has('download')) {
            return Storage::disk('public')->download(
                $test->pdf_path,
                $test->pdf_original_name ?? 'test.pdf'
            );
        }

        $filePath = Storage::disk('public')->path($test->pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($test->pdf_original_name ?? 'test.pdf') . '"'
        ]);
    }

    public function viewPdf(Test $test)
    {
        $this->authorizeTeacher();

        if (!$test->has_pdf || !$test->pdf_path) {
            abort(404, 'PDF not available for this test.');
        }

        if (!Storage::disk('public')->exists($test->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($test->pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($test->pdf_original_name ?? 'test.pdf') . '"'
        ]);
    }

    // ---------------- STUDENT REPORT - FIXED METHOD ---------------- //

    /**
     * Generate comprehensive student report
     */
   /**
 * Generate comprehensive student report - FIXED CALCULATIONS
 */
/**
 * Generate comprehensive student report - FIXED COUNTING
 */
// In TestController.php - FIXED studentReport method
public function studentReport()
{
    $this->authorizeStudent();

    $studentId = Auth::id();

    // Use the SAME pattern as dashboard() to get completed tests count
    $totalTests = TestAnswer::where('student_id', $studentId)
        ->where('marking_status', 'completed')
        ->distinct('test_id')
        ->count('test_id');

    // Use the SAME pattern as results() to get completed tests with answers
    $completedTests = TestAnswer::where('student_id', $studentId)
        ->where('marking_status', 'completed')
        ->with(['test.subject', 'question'])
        ->get()
        ->groupBy('test_id');

    // Calculate overall statistics
    $totalMarks = 0;
    $totalPossibleMarks = 0;
    $subjectPerformance = [];

    foreach ($completedTests as $testId => $answers) {
        $test = $answers->first()->test;
        $subjectName = $test->subject->name;

        // Calculate test marks
        $testMarks = $answers->sum('marks');

        // Calculate possible marks from questions
        $testPossibleMarks = $test->questions()->sum('marks');

        // Fallback: if no questions found, calculate from answers
        if ($testPossibleMarks <= 0) {
            $testPossibleMarks = $answers->sum(function($answer) {
                return $answer->question->marks ?? 1;
            });
        }

        $testPercentage = $testPossibleMarks > 0 ? ($testMarks / $testPossibleMarks) * 100 : 0;

        // Get submission date
        $submissionDate = $answers->first()->submitted_at ?? $answers->first()->created_at;

        // Initialize subject array if not exists
        if (!isset($subjectPerformance[$subjectName])) {
            $subjectPerformance[$subjectName] = [
                'tests' => [],
                'total_marks' => 0,
                'total_possible_marks' => 0,
                'tests_count' => 0
            ];
        }

        // Add test to subject
        $subjectPerformance[$subjectName]['tests'][] = [
            'test_id' => $testId,
            'test_title' => $test->title,
            'marks' => $testMarks,
            'possible_marks' => $testPossibleMarks,
            'percentage' => $testPercentage,
            'performance_level' => $this->getPerformanceLevel($testPercentage),
            'performance_color' => $this->getPerformanceColor($this->getPerformanceLevel($testPercentage)),
            'submitted_at' => $submissionDate
        ];

        // Update subject totals
        $subjectPerformance[$subjectName]['total_marks'] += $testMarks;
        $subjectPerformance[$subjectName]['total_possible_marks'] += $testPossibleMarks;
        $subjectPerformance[$subjectName]['tests_count']++;

        // Update overall totals
        $totalMarks += $testMarks;
        $totalPossibleMarks += $testPossibleMarks;
    }

    // Calculate subject percentages
    foreach ($subjectPerformance as $subjectName => &$subjectData) {
        $subjectPercentage = $subjectData['total_possible_marks'] > 0
            ? ($subjectData['total_marks'] / $subjectData['total_possible_marks']) * 100
            : 0;

        $subjectData['percentage'] = $subjectPercentage;
        $subjectData['performance_level'] = $this->getPerformanceLevel($subjectPercentage);
        $subjectData['performance_color'] = $this->getPerformanceColor($this->getPerformanceLevel($subjectPercentage));
    }

    $overallPercentage = $totalPossibleMarks > 0 ? ($totalMarks / $totalPossibleMarks) * 100 : 0;

    // Get performance level and color
    $performanceLevel = $this->getPerformanceLevel($overallPercentage);
    $performanceColor = $this->getPerformanceColor($performanceLevel);

    // Return view with ALL required variables including $totalTests
    return view('student.report', compact(
        'subjectPerformance',
        'totalTests', // THIS WAS MISSING - CAUSING THE ERROR
        'totalMarks',
        'totalPossibleMarks',
        'overallPercentage',
        'performanceLevel',
        'performanceColor'
    ));
}
    // Helper methods for performance calculation
    private function getPerformanceLevel($percentage)
    {
        if ($percentage >= 90) return 'Excellent';
        if ($percentage >= 80) return 'Very Good';
        if ($percentage >= 70) return 'Good';
        if ($percentage >= 60) return 'Satisfactory';
        if ($percentage >= 50) return 'Average';
        return 'Needs Improvement';
    }

    private function getPerformanceColor($performance)
    {
        switch($performance) {
            case 'Excellent': return 'success';
            case 'Very Good': return 'info';
            case 'Good': return 'primary';
            case 'Satisfactory': return 'warning';
            case 'Average': return 'secondary';
            case 'Needs Improvement': return 'danger';
            default: return 'secondary';
        }
    }

    public function downloadPdf(Test $test)
    {
        $this->authorizeTeacher();

        if (!$test->has_pdf || !$test->pdf_path) {
            abort(404, 'PDF not available for this test.');
        }

        if (!Storage::disk('public')->exists($test->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        return Storage::disk('public')->download(
            $test->pdf_path,
            $test->pdf_original_name ?? 'test.pdf'
        );
    }

    public function downloadAnswerPdf($answerId)
    {
        $this->authorizeTeacher();

        $answer = TestAnswer::findOrFail($answerId);

        if (!$answer->answer_pdf_path) {
            abort(404, 'PDF answer not found.');
        }

        if (!Storage::disk('public')->exists($answer->answer_pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        return Storage::disk('public')->download(
            $answer->answer_pdf_path,
            $answer->answer_pdf_original_name ?? 'answer.pdf'
        );
    }

    public function viewAnswerPdf($answerId)
    {
        $this->authorizeTeacher();

        $answer = TestAnswer::findOrFail($answerId);

        if (!$answer->answer_pdf_path) {
            abort(404, 'PDF answer not found.');
        }

        if (!Storage::disk('public')->exists($answer->answer_pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($answer->answer_pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($answer->answer_pdf_original_name ?? 'answer.pdf') . '"'
        ]);
    }

    public function viewStudentAnswerPdf(Test $test, $answerId)
    {
        $this->authorizeTeacher();

        $answer = TestAnswer::where('id', $answerId)
            ->where('test_id', $test->id)
            ->firstOrFail();

        if (!$answer->answer_pdf_path) {
            abort(404, 'PDF answer not found.');
        }

        if (!Storage::disk('public')->exists($answer->answer_pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($answer->answer_pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($answer->answer_pdf_original_name ?? 'answer.pdf') . '"'
        ]);
    }

    public function downloadStudentAnswerPdf(Test $test, $answerId)
    {
        $this->authorizeTeacher();

        $answer = TestAnswer::where('id', $answerId)
            ->where('test_id', $test->id)
            ->firstOrFail();

        if (!$answer->answer_pdf_path) {
            abort(404, 'PDF answer not found.');
        }

        if (!Storage::disk('public')->exists($answer->answer_pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        return Storage::disk('public')->download(
            $answer->answer_pdf_path,
            $answer->answer_pdf_original_name ?? 'answer.pdf'
        );
    }

    // ---------------- HELPER METHODS ---------------- //

    private function authorizeTeacher()
    {
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeStudent()
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }
    }

    // ---------------- AJAX METHOD ---------------- //

    public function getStudentsByGrade($grade)
    {
        $this->authorizeTeacher();

        $students = User::where('role', 'student')
            ->where('class_grade', $grade)
            ->get(['id', 'name']);

        return response()->json($students);
    }

    public function assignForm($id)
    {
        $this->authorizeTeacher();

        $test = Test::findOrFail($id);
        $classGrades = User::where('role', 'student')
            ->whereNotNull('class_grade')
            ->distinct()
            ->pluck('class_grade');

        return view('tests.assign', compact('test', 'classGrades'));
    }

    // ---------------- PDF MANAGEMENT METHODS ---------------- //

    public function replacePdf(Request $request, Test $test)
    {
        $this->authorizeTeacher();

        $request->validate([
            'question_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($test->pdf_path && Storage::disk('public')->exists($test->pdf_path)) {
            Storage::disk('public')->delete($test->pdf_path);
        }

        $pdfFile = $request->file('question_pdf');
        $pdfPath = $pdfFile->store('test_pdfs', 'public');

        $test->update([
            'has_pdf' => true,
            'pdf_path' => $pdfPath,
            'pdf_original_name' => $pdfFile->getClientOriginalName(),
            'question_type' => 'pdf',
        ]);

        return redirect()->back()->with('success', 'PDF updated successfully.');
    }

    public function removePdf(Test $test)
    {
        $this->authorizeTeacher();

        if ($test->pdf_path && Storage::disk('public')->exists($test->pdf_path)) {
            Storage::disk('public')->delete($test->pdf_path);
        }

        $test->update([
            'has_pdf' => false,
            'pdf_path' => null,
            'pdf_original_name' => null,
            'question_type' => 'manual',
        ]);

        return redirect()->back()->with('success', 'PDF removed successfully.');
    }
}
