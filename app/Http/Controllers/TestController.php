<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Subject;
use App\Models\TestAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        return view('tests.index', compact('tests'));
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
        'questions.*.text' => 'required|string',
        'questions.*.type' => 'required|in:mcq,written',

        // ✅ Conditional validation
        'questions.*.options' => 'required_if:questions.*.type,mcq|nullable|string',
        'questions.*.correct_answer' => 'required_if:questions.*.type,mcq|nullable|integer',

        'questions.*.marks' => 'required|integer|min:1',
    ]);

    // Create the test
    $test = Test::create([
        'title'       => $request->title,
        'subject_id'  => $request->subject_id,
        'scheduled_at'=> Carbon::parse($request->scheduled_at),
        'teacher_id'  => Auth::id(),
    ]);

    // Save questions
    foreach ($request->questions as $q) {
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
            'type'           => $q['type'], // mcq or written
            'marks'          => $q['marks'] ?? 1,
            'options'        => $optionsArray ? json_encode($optionsArray) : null,
            'correct_answer' => $correctAnswer,
        ]);
    }

    return redirect()->route('tests.index')->with('success', 'Test created successfully.');
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

    // Student dashboard (list all tests)
    public function dashboard()
    {
        $this->authorizeStudent();

        $tests = Test::with('subject')->get();
        return view('student.dashboard', compact('tests'));
    }

    // Show test for student to take
    public function take(Test $test)
    {
        $this->authorizeStudent();

        $test->load('questions', 'subject');
        return view('student.test', compact('test'));
    }

    // Handle student submission
    public function submit(Request $request, Test $test)
    {
        $this->authorizeStudent();

        $request->validate([
            'answers' => 'required|array',
        ]);

        foreach ($request->answers as $questionId => $answer) {
            TestAnswer::updateOrCreate(
                [
                    'test_id'     => $test->id,
                    'student_id'  => Auth::id(),
                    'question_id' => $questionId,
                ],
                [
                    'answer' => is_array($answer) ? json_encode($answer) : $answer,
                ]
            );
        }

        return redirect()->route('student.dashboard')->with('success', 'Test submitted successfully!');
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
}
