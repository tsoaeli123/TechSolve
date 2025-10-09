@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ $test->title }}</h2>
    <p><strong>Subject:</strong> {{ $test->subject->name ?? 'N/A' }}</p>
    <p><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->format('d M Y H:i') : 'Not set' }}</p>

    {{-- Check if deadline has passed --}}
    @php
        $now = now();
        $deadlinePassed = $test->scheduled_at && $now->greaterThan($test->scheduled_at);
        $existingSubmission = $existingAnswers->first(); // Get any existing answer
    @endphp

    @if($deadlinePassed)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>Test Deadline Passed</strong> - The submission deadline for this test was {{ $test->scheduled_at->format('d M Y H:i') }}.
            You can no longer submit answers for this test.
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-sm ms-2">Return to Dashboard</a>
        </div>
    @endif

    {{-- Display Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Show previous submission info --}}
    @if($existingSubmission && !$deadlinePassed)
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            You have previously submitted this test on {{ $existingSubmission->created_at->format('d M Y H:i') }}.
            @if($existingSubmission->answer_pdf_path)
                <br><small>Submitted file: {{ $existingSubmission->answer_pdf_original_name }}</small>
            @endif
            <br><small><strong>Note:</strong> You can submit again before the deadline. Your latest submission will be considered.</small>
        </div>
    @endif

    {{-- PDF Question Paper Section --}}
    @if($test->has_pdf)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-pdf"></i>
                    PDF Question Paper
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <p class="mb-2">This test contains a PDF question paper. Please download and complete the questions in the PDF.</p>
                    <p class="mb-0"><strong>Instructions:</strong> Download the PDF, complete your answers, and upload your solution below.</p>
                </div>

                <div class="d-flex gap-3 align-items-center">
                    {{-- View PDF Button --}}
                    <a href="{{ route('student.tests.view-pdf', $test->id) }}"
                       target="_blank"
                       class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> View PDF
                    </a>

                    {{-- Download PDF Button --}}
                    <a href="{{ route('student.tests.view-pdf', $test->id) }}?download=1"
                       class="btn btn-success">
                        <i class="bi bi-download"></i> Download Question Paper
                    </a>

                    <span class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        {{ $test->pdf_original_name }}
                    </span>
                </div>
            </div>
        </div>

        {{-- PDF Answer Submission Section --}}
        @if(!$deadlinePassed)
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-upload"></i>
                        Submit Your Answer
                    </h5>
                </div>
                <div class="card-body">
                   <form action="{{ route('student.tests.submit-pdf', $test->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="answer_pdf" class="form-label">
                                <strong>Upload Your Completed Answer PDF</strong>
                            </label>
                            <input type="file"
                                   class="form-control @error('answer_pdf') is-invalid @enderror"
                                   id="answer_pdf"
                                   name="answer_pdf"
                                   accept=".pdf"
                                   required>
                            <div class="form-text">
                                Upload your completed answer sheet as a PDF file (Max: 10MB)
                            </div>

                            {{-- Display PDF upload errors --}}
                            @error('answer_pdf')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-send"></i>
                            @if($existingSubmission)
                                Update Submission
                            @else
                                Submit Answer PDF
                            @endif
                        </button>

                        @if($existingSubmission)
                            <div class="form-text text-warning mt-2">
                                <i class="bi bi-exclamation-triangle"></i>
                                Submitting again will replace your previous submission.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        @endif

    {{-- Regular Questions Section --}}
    @else
        @if(!$deadlinePassed)
            <form action="{{ route('student.tests.submit', $test->id) }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Test Questions</h5>
                    </div>
                    <div class="card-body">
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
                                                       id="q{{ $question->id }}_{{ $index }}"
                                                       {{ ($existingAnswers->get($question->id)?->answer ?? '') === $option ? 'checked' : '' }}
                                                       required>
                                                <label for="q{{ $question->id }}_{{ $index }}" class="form-check-label">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach

                                    {{-- Written --}}
                                    @elseif($question->type === 'written')
                                        @php
                                            $previousAnswer = $existingAnswers->get($question->id)?->answer ?? '';
                                        @endphp
                                        <textarea id="text-answer-{{ $question->id }}"
                                                  name="answers[{{ $question->id }}]"
                                                  class="form-control mb-2"
                                                  rows="3"
                                                  placeholder="Write your answer here..."
                                                  required>{{ $previousAnswer }}</textarea>

                                        {{-- Whiteboard Toggle --}}
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm mb-2"
                                                onclick="toggleWhiteboard({{ $question->id }})">
                                            📝 Open Whiteboard
                                        </button>

                                        <div id="whiteboard-container-{{ $question->id }}" class="d-none mb-3">
                                            <div class="toolbar mb-2">
                                                <button type="button" class="btn btn-sm btn-dark" onclick="setTool({{ $question->id }}, 'pen')">✏️ Pen</button>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="setTool({{ $question->id }}, 'eraser')">🧽 Eraser</button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="clearBoard({{ $question->id }})">🗑️ Clear</button>
                                                <button type="button" class="btn btn-sm btn-warning" onclick="undo({{ $question->id }})">↩️ Undo</button>
                                                <input type="color" id="color-{{ $question->id }}" onchange="setColor({{ $question->id }}, this.value)">
                                            </div>

                                            <canvas id="canvas-{{ $question->id }}" width="600" height="300" class="border rounded w-100"></canvas>
                                            <input type="hidden" name="whiteboard_answers[{{ $question->id }}]" id="whiteboard-input-{{ $question->id }}">
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ol>

                        <button type="submit" class="btn btn-success" onclick="saveAllWhiteboards()">
                            <i class="bi bi-send"></i>
                            @if($existingSubmission)
                                Update Test Submission
                            @else
                                Submit Test
                            @endif
                        </button>

                        @if($existingSubmission)
                            <div class="form-text text-warning mt-2">
                                <i class="bi bi-exclamation-triangle"></i>
                                Submitting again will replace your previous answers.
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        @endif
    @endif
</div>

{{-- Fabric.js --}}
@if(!$test->has_pdf && !$deadlinePassed)
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<script>
let boards = {}; // store canvases + states

function toggleWhiteboard(id) {
    let container = document.getElementById('whiteboard-container-' + id);
    container.classList.toggle('d-none');

    if (!boards[id]) {
        let canvas = new fabric.Canvas('canvas-' + id, {
            isDrawingMode: true,
            backgroundColor: '#fff'
        });
        canvas.freeDrawingBrush.width = 2;
        canvas.freeDrawingBrush.color = '#000';

        boards[id] = {
            canvas: canvas,
            history: [],
            redo: []
        };

        // track history for undo
        canvas.on('object:added', () => {
            boards[id].history.push(JSON.stringify(canvas));
        });
    }
}

function setTool(id, tool) {
    let board = boards[id];
    if (!board) return;

    if (tool === 'pen') {
        board.canvas.isDrawingMode = true;
        board.canvas.freeDrawingBrush = new fabric.PencilBrush(board.canvas);
        board.canvas.freeDrawingBrush.width = 2;
        board.canvas.freeDrawingBrush.color = document.getElementById('color-' + id).value;
    } else if (tool === 'eraser') {
        board.canvas.isDrawingMode = true;
        board.canvas.freeDrawingBrush = new fabric.EraserBrush(board.canvas);
        board.canvas.freeDrawingBrush.width = 10;
    }
}

function setColor(id, color) {
    let board = boards[id];
    if (board && board.canvas.isDrawingMode && board.canvas.freeDrawingBrush.color) {
        board.canvas.freeDrawingBrush.color = color;
    }
}

function clearBoard(id) {
    let board = boards[id];
    if (board) {
        board.canvas.clear();
        board.canvas.backgroundColor = '#fff';
    }
}

function undo(id) {
    let board = boards[id];
    if (board && board.history.length > 0) {
        board.history.pop(); // remove last action
        let prev = board.history[board.history.length - 1];
        if (prev) {
            board.canvas.loadFromJSON(prev, () => board.canvas.renderAll());
        } else {
            clearBoard(id);
        }
    }
}

function saveAllWhiteboards() {
    Object.keys(boards).forEach(id => {
        let dataURL = boards[id].canvas.toDataURL('image/png');

        // Save to hidden input (so DB stores it separately)
        document.getElementById('whiteboard-input-' + id).value = dataURL;

        // ALSO append into the textarea so text + drawing go together
        let textarea = document.getElementById('text-answer-' + id);
        if (textarea) {
            textarea.value += "\n\n[Whiteboard Answer Attached Below]\n" + dataURL;
        }
    });
}
</script>
@endif

<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.btn {
    border-radius: 6px;
}

.toolbar {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.toolbar input[type="color"] {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.alert {
    border-radius: 8px;
    border: none;
}

.invalid-feedback {
    display: block;
}
</style>

{{-- Add JavaScript for better UX --}}
<script>
// Show loading state when submitting PDF
document.addEventListener('DOMContentLoaded', function() {
    const pdfForm = document.querySelector('form[action*="submit-pdf"]');
    const submitBtn = document.getElementById('submitBtn');

    if (pdfForm && submitBtn) {
        pdfForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Uploading...';
        });
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Show time remaining until deadline
    @if($test->scheduled_at && !$deadlinePassed)
        const deadline = new Date('{{ $test->scheduled_at }}');
        function updateCountdown() {
            const now = new Date();
            const timeLeft = deadline - now;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = '<strong>Time\'s up!</strong>';
                location.reload(); // Reload to show deadline passed message
                return;
            }

            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML =
                `<strong>Time remaining:</strong> ${hours}h ${minutes}m ${seconds}s`;
        }

        // Add countdown element
        const countdownEl = document.createElement('div');
        countdownEl.className = 'alert alert-info';
        countdownEl.id = 'countdown';
        document.querySelector('.container').insertBefore(countdownEl, document.querySelector('.container').firstChild);

        updateCountdown();
        setInterval(updateCountdown, 1000);
    @endif
});
</script>
@endsection
