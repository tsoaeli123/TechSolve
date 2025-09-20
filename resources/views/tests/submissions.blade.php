@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Submissions for: {{ $test->title }}</h2>
    <a href="{{ route('tests.index') }}" class="btn btn-secondary mb-3">Back to Tests</a>

    @forelse($submissions as $studentId => $answers)
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <strong>Student:</strong> {{ $answers->first()->student->name }}
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($answers as $answer)
                        <li class="list-group-item">
                            <strong>Question:</strong> {{ $answer->question->question_text }} <br>
                            <strong>Answer:</strong> {{ $answer->answer }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p>No submissions yet.</p>
    @endforelse
</div>
@endsection
