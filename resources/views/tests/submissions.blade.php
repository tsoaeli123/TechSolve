@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $test->subject->title }} — {{ $test->title }}</h2>
    </div>

    <a href="{{ route('tests.index') }}" class="btn btn-secondary mb-3">Back to Tests</a>

    <!-- Student List -->
    <div class="list-group">
        @forelse($submissions as $studentId => $answers)
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse" href="#student-{{ $studentId }}" role="button">
                <div>
                    <strong>{{ $answers->first()->student->name }}</strong>
                    <span class="ms-3 text-muted">ID: {{ $answers->first()->student->id }}</span>
                </div>
                <span class="badge bg-primary">
                    Total Marks: {{ $answers->sum('question.marks') }}
                </span>
            </a>

            <!-- Collapsible Student Answers -->
            <div class="collapse mt-3" id="student-{{ $studentId }}">
                <div class="card mb-4 shadow-sm printable-page">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{ $test->subject->title }}</h4>
                            <p class="mb-1"><strong>Exam:</strong> {{ $test->title }}</p>
                            <p class="mb-1"><strong>Student:</strong> {{ $answers->first()->student->name }}</p>
                            <p class="mb-1"><strong>ID:</strong> {{ $answers->first()->student->id }}</p>
                        </div>
                        <button onclick="printStudent('student-{{ $studentId }}')" class="btn btn-sm btn-primary">
                            Download QP
                        </button>
                    </div>
                    <div class="card-body">

                        <!-- Teacher Marking Form -->
                        <form action="{{ route('submissions.grade', [$test->id, $studentId]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @foreach($answers as $answer)
                                <div class="question-item mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">
                                            Q{{ $loop->iteration }}: {{ $answer->question->question_text }}
                                        </h6>
                                        <span class="fw-bold">( {{ $answer->question->marks }} marks )</span>
                                    </div>

                                    <div class="student-answer bg-light p-3 rounded mb-3">
                                        <strong>Student's Answer:</strong><br>

                                        @php
                                            $ans = $answer->answer;
                                        @endphp

                                        {{-- If answer contains whiteboard (base64 image) --}}
                                        @if(Str::contains($ans, 'data:image/png;base64'))
                                            @php
                                                // Split text + images if both exist
                                                $parts = preg_split('/(data:image\/png;base64,[A-Za-z0-9+\/=]+)/', $ans, -1, PREG_SPLIT_DELIM_CAPTURE);
                                            @endphp

                                            @foreach($parts as $part)
                                                @if(Str::startsWith($part, 'data:image/png;base64'))
                                                    <div class="mt-2">
                                                        <img src="{{ $part }}" alt="Whiteboard Answer" class="img-fluid border rounded">
                                                    </div>
                                                @elseif(trim($part) !== '')
                                                    <p>{{ $part }}</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{ $ans }}</p>
                                        @endif
                                    </div>

                                    <div class="marking-section mt-2">
                                        <div class="d-flex align-items-center mb-3">
                                            <label class="me-2"><strong>Marks Awarded:</strong></label>
                                            <input type="number"
                                                   name="marks[{{ $answer->id }}]"
                                                   class="form-control marks-input me-2"
                                                   style="width: 80px;" min="0"
                                                   max="{{ $answer->question->marks }}"
                                                   value="{{ $answer->marks ?? '' }}"
                                                   placeholder="0">
                                            <span>/ {{ $answer->question->marks }}</span>
                                        </div>
                                        <div>
                                            <label><strong>Comments:</strong></label>
                                            <textarea name="comments[{{ $answer->id }}]"
                                                      class="form-control"
                                                      rows="2"
                                                      placeholder="Write comments...">{{ $answer->comments ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Upload Marked PDF -->
                            <div class="mt-4">
                                <label><strong>Upload Marked PDF (optional):</strong></label>
                                <input type="file" name="marked_paper" class="form-control" accept="application/pdf">
                            </div>

                            <div class="total-section border-top pt-3 mt-4">
                                <h5>Total Marks:
                                    <span class="total-marks-display">0</span>
                                    / {{ $answers->sum('question.marks') }}
                                </h5>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Submit Marks</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No submissions yet.</p>
        @endforelse
    </div>
</div>

<style>
    .printable-page { background: white; padding: 20px; }
    .marks-input { border: 2px solid #007bff; font-weight: bold; text-align: center; }
    .student-answer { border-left: 4px solid #007bff; }
    .question-item { background: #fff; }
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; }
    }
</style>

<script>
function printStudent(studentId) {
    let section = document.querySelector(`#${studentId} .printable-page`);
    if (!section) return;

    let printWindow = window.open('', '', 'width=900,height=650');
    printWindow.document.write('<html><head><title>Student Paper</title>');
    printWindow.document.write('<style>body{font-family:Arial;} .marks-input{border:1px solid #000;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(section.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Update total marks when inputs change
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('marks-input')) {
        let card = e.target.closest('.card');
        updateTotalMarks(card);
    }
});
function updateTotalMarks(card) {
    let total = 0;
    card.querySelectorAll('.marks-input').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    let totalDisplay = card.querySelector('.total-marks-display');
    if (totalDisplay) totalDisplay.textContent = total;
}
</script>
@endsection
