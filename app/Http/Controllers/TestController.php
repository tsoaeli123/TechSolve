<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Subject;
use App\Models\TestAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ---------------- TEACHER SIDE ---------------- //

    // List all tests for the teacher
    public function index()
    {
        $this->authorizeTeacher();

        $tests = Test::where('teacher_id', Auth::id())->with('subject')->get();

        // Get unique student class grades
        $classGrades = User::where('role', 'student')
            ->whereNotNull('class_grade')
            ->distinct()
            ->pluck('class_grade');

        return view('tests.index', compact('tests', 'classGrades'));
    }

    // Show form to create a test
    public function create()
    {
        $this->authorizeTeacher();

        $subjects = Subject::all();
        return view('tests.create', compact('subjects'));
    }

    // Store a new test with questions
    public function store(Request $request)
    {
        $this->authorizeTeacher();

        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'scheduled_at' => 'required|date',
            'questions' => 'required|array',
            'questions.*.text' => 'required',
            'questions.*.type' => 'required|in:mcq,written',
            'questions.*.options' => 'required_if:questions.*.type,mcq|nullable|string',
            'questions.*.correct_answer' => 'required_if:questions.*.type,mcq|nullable|integer',
            'questions.*.marks' => 'required|integer|min:1',
            'math_content' => 'sometimes|array',
        ]);

        $test = Test::create([
            'title'       => $request->title,
            'subject_id'  => $request->subject_id,
            'scheduled_at'=> Carbon::parse($request->scheduled_at),
            'teacher_id'  => Auth::id(),
        ]);

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

        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }

    public function viewSubmissions(Test $test)
    {
        $this->authorizeTeacher();

        // Load submitted answers with student info and questions
        $submissions = TestAnswer::where('test_id', $test->id)
            ->with(['student', 'question'])
            ->get()
            ->groupBy('student_id');

        return view('tests.submissions', compact('test', 'submissions'));
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

    // Show test details for teacher
    public function show(Test $test)
    {
        $this->authorizeTeacher();

        $test->load('questions', 'subject');
        return view('tests.show', compact('test'));
    }

    // Show edit form for test
    public function edit(Test $test)
    {
        $this->authorizeTeacher();

        $subjects = Subject::all();
        return view('tests.edit', compact('test', 'subjects'));
    }

    // Update a test
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

    // Delete a test
    public function destroy(Test $test)
    {
        $this->authorizeTeacher();

        $test->delete();

        return redirect()->route('tests.index')->with('success', 'Test deleted successfully.');
    }

    // ---------------- STUDENT SIDE ---------------- //

    public function dashboard()
    {
        $this->authorizeStudent();

        $studentClass = Auth::user()->class_grade;

        // Get tests assigned to this student's class
        $tests = Test::whereHas('assignedTests', function($query) use ($studentClass) {
            $query->where('class_grade', $studentClass);
        })->with('subject')->get();

        return view('student.dashboard', compact('tests'));
    }

    public function take(Test $test)
    {
        $this->authorizeStudent();

        $test->load('questions', 'subject');
        return view('student.test', compact('test'));
    }

    public function submit(Request $request, Test $test)
    {
        $this->authorizeStudent();

        $request->validate([
            'answers' => 'required|array',
        ]);

        $test->load('questions');

        foreach ($request->answers as $questionId => $answer) {
            $question = $test->questions->firstWhere('id', $questionId);

            // default score = null for written, 0 for mcq
            $score = null;
            $studentAnswer = is_array($answer) ? json_encode($answer) : $answer;

            if ($question && $question->type === 'mcq') {
                $options = json_decode($question->options, true);
                $correctIndex = (int)$question->correct_answer;
                $correctValue = $options[$correctIndex] ?? null;

                // Always give 0 if wrong
                $score = ($studentAnswer === $correctValue)
                    ? $question->marks
                    : 0;
            }

            TestAnswer::updateOrCreate(
                [
                    'test_id'     => $test->id,
                    'student_id'  => Auth::id(),
                    'question_id' => $questionId,
                ],
                [
                    'answer' => $studentAnswer,
                    'score'  => $score,
                ]
            );
        }

        return redirect()->route('student.dashboard')->with('success', 'Test submitted successfully!');
    }

    // ---------------- PDF VIEWING METHODS ---------------- //

    /**
     * View PDF for students
     */
    public function viewStudentPdf(Test $test)
    {
        $this->authorizeStudent();

        // Check if test has PDF
        if (!$test->has_pdf || !$test->pdf_path) {
            abort(404, 'PDF not available for this test.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($test->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        // Return PDF as response
        $filePath = Storage::disk('public')->path($test->pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($test->pdf_original_name ?? 'test.pdf') . '"'
        ]);
    }

    /**
     * View PDF for teachers
     */
    public function viewPdf(Test $test)
    {
        $this->authorizeTeacher();

        // Check if test has PDF
        if (!$test->has_pdf || !$test->pdf_path) {
            abort(404, 'PDF not available for this test.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($test->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        // Return PDF as response
        $filePath = Storage::disk('public')->path($test->pdf_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($test->pdf_original_name ?? 'test.pdf') . '"'
        ]);
    }

    /**
     * Download PDF for teachers
     */
    public function downloadAnswerPdf($answerId)
    {
        $this->authorizeTeacher();
        // Add your download logic here if needed
    }

    /**
     * View answer PDF for teachers
     */
    public function viewAnswerPdf($answerId)
    {
        $this->authorizeTeacher();
        // Add your view answer PDF logic here if needed
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
}
