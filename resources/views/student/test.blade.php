@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ $test->title }}</h2>
    <p><strong>Subject:</strong> {{ $test->subject->name ?? 'N/A' }}</p>
    <p><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->format('d M Y H:i') : 'Not set' }}</p>

    {{-- Start answer form --}}
    <form action="{{ route('student.tests.submit', $test->id) }}" method="POST">
        @csrf

        <ol>
            @foreach($test->questions as $question)
                <li class="mb-4">
                    <p>
                        <strong>{{ $question->question_text }}</strong>
                        <em>({{ ucfirst($question->type) }}, {{ $question->marks }} marks)</em>
                    </p>

                    {{-- Multiple Choice --}}
                    @if($question->type === 'mcq' && $question->options)
                        @foreach(json_decode($question->options) as $index => $option)
                            <div class="form-check">
                                <input type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $option }}"
                                       class="form-check-input"
                                       id="q{{ $question->id }}_{{ $index }}">
                                <label for="q{{ $question->id }}_{{ $index }}" class="form-check-label">
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach

                    {{-- Written --}}
                    @elseif($question->type === 'written')
                        <textarea name="answers[{{ $question->id }}]"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Write your answer here..."></textarea>
                    @endif
                </li>
            @endforeach
        </ol>

        <button type="submit" class="btn btn-success">Submit Test</button>
    </form>
</div>
@endsection
