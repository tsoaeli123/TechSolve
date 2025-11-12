@extends('layouts.app')

@section('content')
@php
    // Ensure times are shown in app timezone (explicitly)
    $now = now()->setTimezone(config('app.timezone'));

    $deadlinePassed = $test->isExpired();
    $testNotStarted = $test->isUpcoming();
    $testActive = $test->isActive();

    $existingSubmission = $existingAnswers->first();
    $statusInfo = $test->getDetailedStatus();

    // New badge when created within last 7 days
    $isNew = $test->created_at && $test->created_at->gt(now()->subDays(7));
@endphp

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11 col-md-12">

            {{-- Header card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $test->title }}
                            @if($isNew)
                                <span class="badge bg-success ms-2">NEW</span>
                            @endif
                        </h3>
                        <div class="text-muted small mt-1">
                            <strong>Subject:</strong> {{ $test->subject->name ?? 'N/A' }}
                            &middot;
                            <strong>Created:</strong> {{ $test->created_at ? $test->created_at->setTimezone(config('app.timezone'))->format('d M Y') : '—' }}
                        </div>
                    </div>

                    <div class="text-end">
                        <div class="small text-muted">Status</div>
                        @if($testActive)
                            <div class="badge bg-info text-dark px-3 py-2">Active</div>
                        @elseif($testNotStarted)
                            <div class="badge bg-warning text-dark px-3 py-2">Upcoming</div>
                        @elseif($deadlinePassed)
                            <div class="badge bg-secondary px-3 py-2">Expired</div>
                        @else
                            <div class="badge bg-light text-dark px-3 py-2">Unknown</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Debug / Info card (remove in production) --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Debug Info (Corrected Logic)</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Current Time:</strong> {{ $now->format('Y-m-d H:i:s') }} ({{ config('app.timezone') }})</p>
                            <p class="mb-1"><strong>Start Time:</strong> {{ $test->start_time ? $test->start_time->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') : 'N/A' }}</p>
                            <p class="mb-1"><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') : 'N/A' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Is Expired:</strong> {{ $deadlinePassed ? 'Yes' : 'No' }}</p>
                            <p class="mb-1"><strong>Is Upcoming:</strong> {{ $testNotStarted ? 'Yes' : 'No' }}</p>
                            <p class="mb-1"><strong>Is Active:</strong> {{ $testActive ? 'Yes' : 'No' }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $test->status }}</p>
                        </div>
                    </div>

                    @if($testNotStarted)
                        <div class="mt-2 small text-muted">
                            <strong>Time Until Start:</strong> {{ $statusInfo['time_until_start'] ?? 'N/A' }}
                        </div>
                    @elseif($deadlinePassed)
                        <div class="mt-2 small text-muted">
                            <strong>Time Since Deadline:</strong> {{ $statusInfo['time_since_deadline'] ?? 'N/A' }}
                        </div>
                    @elseif($testActive && $test->scheduled_at)
                        <div class="mt-2 small text-muted">
                            <strong>Time Until Deadline:</strong> {{ $statusInfo['time_until_deadline'] ?? 'N/A' }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Alerts from session --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Blocking error when not available --}}
            @if(session('error') && ($testNotStarted || $deadlinePassed))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Test Not Available</strong><br>
                    {{ session('error') }}

                    @if($testNotStarted)
                        <div class="mt-2 small text-muted">
                            <strong>Start Time:</strong> {{ $test->start_time->setTimezone(config('app.timezone'))->format('d M Y H:i') }}<br>
                            <strong>Time Until Start:</strong> {{ $statusInfo['time_until_start'] ?? 'N/A' }}
                        </div>
                    @endif

                    @if($deadlinePassed)
                        <div class="mt-2 small text-muted">
                            <strong>Deadline Was:</strong> {{ $test->scheduled_at->setTimezone(config('app.timezone'))->format('d M Y H:i') }}<br>
                            <strong>Time Since Deadline:</strong> {{ $statusInfo['time_since_deadline'] ?? 'N/A' }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left"></i> Return to Dashboard
                        </a>
                    </div>
                </div>
            @endif

            {{-- Previous submission info (active tests) --}}
            @if($testActive && $existingSubmission)
                <div class="alert alert-info shadow-sm">
                    <i class="bi bi-info-circle me-2"></i>
                    You previously submitted this test on {{ $existingSubmission->created_at->setTimezone(config('app.timezone'))->format('d M Y H:i') }}.
                    @if($existingSubmission->answer_pdf_path)
                        <br><small>Submitted file: {{ $existingSubmission->answer_pdf_original_name }}</small>
                    @endif
                    <br><small class="text-muted"><strong>Note:</strong> You can submit again before the deadline. Your latest submission will be used.</small>
                </div>
            @endif

            {{-- If upcoming show a clean preview card (NO QUESTIONS) --}}
            @if($testNotStarted)
                <div class="card mb-4 shadow-sm border-light">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-muted"><i class="bi bi-eye me-2"></i> Test Preview</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Start Time:</strong> {{ $test->start_time ? $test->start_time->setTimezone(config('app.timezone'))->format('d M Y H:i') : 'Not set' }}</p>
                        <p class="mb-1"><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->setTimezone(config('app.timezone'))->format('d M Y H:i') : 'Not set' }}</p>
                        <p class="text-muted small">Questions will become visible automatically when the test starts. You may view any PDF question paper below.</p>
                    </div>
                </div>
            @endif

            {{-- PDF Section (visible anytime) --}}
            @if($test->has_pdf)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-pdf me-2"></i> PDF Question Paper</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-2">This test contains a PDF question paper. Download, complete, and re-upload your answers below.</p>
                                <p class="mb-0 small text-muted"><strong>Original file:</strong> {{ $test->pdf_original_name }}</p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="{{ route('student.tests.view-pdf', $test->id) }}" target="_blank" class="btn btn-outline-light me-2">
                                    <i class="bi bi-eye"></i> View PDF
                                </a>
                                <a href="{{ route('student.tests.view-pdf', $test->id) }}?download=1" class="btn btn-light">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PDF upload card --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header {{ $testActive ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                        <h5 class="mb-0"><i class="bi bi-upload me-2"></i>
                            @if($testActive) Submit Your Answer @else Answer Submission (Disabled) @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.tests.submit-pdf', $test->id) }}" method="POST" enctype="multipart/form-data" id="pdfForm">
                            @csrf

                            <div class="mb-3">
                                <label for="answer_pdf" class="form-label"><strong>Upload Your Completed Answer PDF</strong>
                                    @if(!$testActive)
                                        <span class="badge bg-warning text-dark ms-2">Disabled</span>
                                    @endif
                                </label>
                                <input type="file"
                                       class="form-control @error('answer_pdf') is-invalid @enderror"
                                       id="answer_pdf"
                                       name="answer_pdf"
                                       accept=".pdf"
                                       {{ $testActive ? 'required' : 'disabled' }}>
                                <div class="form-text">
                                    Upload your completed answer sheet as a PDF file (Max: 10MB).
                                </div>

                                @error('answer_pdf')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if($testActive)
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-send me-2"></i> {{ $existingSubmission ? 'Update Submission' : 'Submit Answer PDF' }}
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary" disabled><i class="bi bi-slash-circle me-2"></i> Submission Disabled</button>
                            @endif
                        </form>
                    </div>
                </div>
            @endif

            {{-- QUESTIONS: Only render questions when the test is ACTIVE (strictly) --}}
            @if($testActive && !$test->has_pdf)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i> Test Questions</h5>
                            @if($test->scheduled_at)
                                <div class="small">Deadline: {{ $test->scheduled_at->setTimezone(config('app.timezone'))->format('d M Y H:i') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.tests.submit', $test->id) }}" method="POST" id="testForm">
                            @csrf
                            <ol class="mb-4">
                                @foreach($test->questions as $question)
                                    <li class="mb-4">
                                        <p class="mb-2"><strong>{{ $question->question_text }}</strong>
                                            <span class="text-muted small"> — {{ ucfirst($question->type) }}, {{ $question->marks }} marks</span>
                                        </p>

                                        @if($question->type === 'mcq' && $question->options)
                                            @foreach(json_decode($question->options) as $index => $option)
                                                @php $checked = ($existingAnswers->get($question->id)?->answer ?? '') === $option; @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="answers[{{ $question->id }}]"
                                                           id="q{{ $question->id }}_{{ $index }}"
                                                           value="{{ $option }}"
                                                           {{ $checked ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $index }}">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @elseif($question->type === 'written')
                                            @php $previousAnswer = $existingAnswers->get($question->id)?->answer ?? ''; @endphp
                                            <textarea id="text-answer-{{ $question->id }}"
                                                      name="answers[{{ $question->id }}]"
                                                      class="form-control mb-2"
                                                      rows="4"
                                                      placeholder="Write your answer here...">{{ $previousAnswer }}</textarea>

                                            {{-- Whiteboard (active only) --}}
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="toggleWhiteboard({{ $question->id }})">
                                                📝 Open Whiteboard
                                            </button>
                                            <div id="whiteboard-container-{{ $question->id }}" class="d-none mb-3">
                                                <div class="toolbar mb-2">
                                                    <button type="button" class="btn btn-sm btn-dark" onclick="setTool({{ $question->id }}, 'pen')">✏️</button>
                                                    <button type="button" class="btn btn-sm btn-secondary" onclick="setTool({{ $question->id }}, 'eraser')">🧽</button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="clearBoard({{ $question->id }})">🗑️</button>
                                                    <button type="button" class="btn btn-sm btn-warning" onclick="undo({{ $question->id }})">↩️</button>
                                                    <input type="color" id="color-{{ $question->id }}" onchange="setColor({{ $question->id }}, this.value)">
                                                </div>

                                                <canvas id="canvas-{{ $question->id }}" width="800" height="360" class="border rounded w-100"></canvas>
                                                <input type="hidden" name="whiteboard_answers[{{ $question->id }}]" id="whiteboard-input-{{ $question->id }}">
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>

                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-success" id="testSubmitBtn" onclick="saveAllWhiteboards()">
                                    <i class="bi bi-send me-2"></i> {{ $existingSubmission ? 'Update Test Submission' : 'Submit Test' }}
                                </button>

                                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif(!$testActive && !$testNotStarted && !$deadlinePassed)
                {{-- Safety fallback --}}
                <div class="alert alert-secondary shadow-sm">
                    <i class="bi bi-info-circle me-2"></i> This test is currently not accessible.
                </div>
            @endif

            {{-- If expired and no PDF, show results-only card --}}
            @if($deadlinePassed && !$test->has_pdf && !$testActive)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Test Finished</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">The test deadline has passed. You can view results or contact your instructor for questions.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Fabric.js - Only when active and written questions present --}}
@if($testActive && !$test->has_pdf)
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<script>
let boards = {};

function toggleWhiteboard(id) {
    let container = document.getElementById('whiteboard-container-' + id);
    container.classList.toggle('d-none');

    if (!boards[id]) {
        const canvasEl = document.getElementById('canvas-' + id);
        let canvas = new fabric.Canvas(canvasEl, {
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

        canvas.on('object:added', () => {
            try {
                boards[id].history.push(JSON.stringify(canvas));
            } catch (e) {
                // ignore serialization errors
            }
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
        let colorEl = document.getElementById('color-' + id);
        board.canvas.freeDrawingBrush.color = colorEl ? colorEl.value : '#000';
    } else if (tool === 'eraser') {
        board.canvas.isDrawingMode = true;
        board.canvas.freeDrawingBrush = new fabric.EraserBrush(board.canvas);
        board.canvas.freeDrawingBrush.width = 12;
    }
}

function setColor(id, color) {
    let board = boards[id];
    if (board && board.canvas.isDrawingMode && board.canvas.freeDrawingBrush) {
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
        board.history.pop();
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
        const hidden = document.getElementById('whiteboard-input-' + id);
        if (hidden) hidden.value = dataURL;

        // append to any associated textarea
        const textarea = document.getElementById('text-answer-' + id);
        if (textarea) {
            textarea.value = (textarea.value || '') + "\n\n[Whiteboard Attached Below]\n" + dataURL;
        }
    });
}
</script>
@endif

<style>
/* University-style clean look */
body {
    background-color: #f5f7fa;
}
.card {
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
h3, h5 {
    font-family: "Inter", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
.btn {
    border-radius: 6px;
}
.badge {
    font-weight: 600;
}
.toolbar .btn {
    min-width: 36px;
}
.alert {
    border-radius: 8px;
}
</style>

{{-- Page JS: countdown and submit handling --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Forms and submit buttons
    const pdfForm = document.getElementById('pdfForm');
    const testForm = document.getElementById('testForm');
    const submitBtn = document.getElementById('submitBtn');
    const testSubmitBtn = document.getElementById('testSubmitBtn');

    if (pdfForm && submitBtn) {
        pdfForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Uploading...';
        });
    }

    if (testForm && testSubmitBtn) {
        testForm.addEventListener('submit', function() {
            saveAllWhiteboards();
            testSubmitBtn.disabled = true;
            testSubmitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Submitting...';
        });
    }

    // Auto-dismiss non-critical alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (!alert.classList.contains('alert-warning') && !alert.classList.contains('alert-danger')) {
                try {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                } catch(e) {}
            }
        });
    }, 5000);

    // Countdown to start (if upcoming)
    @if($testNotStarted && $test->start_time)
        const startTime = new Date('{{ $test->start_time->setTimezone(config('app.timezone'))->format("Y-m-d\\TH:i:sP") }}');

        function updateStartCountdown() {
            const now = new Date();
            const timeLeft = startTime - now;

            const el = document.getElementById('countdown-to-start');
            if (!el) return;

            if (timeLeft <= 0) {
                el.innerHTML = 'Test Starting...';
                // Hard reload so server-side logic flips to active
                window.location.reload(true);
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            let countdownText = '';
            if (days > 0) {
                countdownText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else if (hours > 0) {
                countdownText = `${hours}h ${minutes}m ${seconds}s`;
            } else {
                countdownText = `${minutes}m ${seconds}s`;
            }

            el.innerHTML = countdownText;
        }

        // create the element if present in any preview card
        if (!document.getElementById('countdown-to-start')) {
            const preview = document.querySelector('.card .card-body');
            // we already displayed textual time; the preview card contains the message only
        } else {
            updateStartCountdown();
            setInterval(updateStartCountdown, 1000);
        }
    @endif

    // Countdown to deadline for active tests
    @if($testActive && $test->scheduled_at)
        const deadline = new Date('{{ $test->scheduled_at->setTimezone(config('app.timezone'))->format("Y-m-d\\TH:i:sP") }}');

        function updateDeadlineCountdown() {
            const now = new Date();
            const timeLeft = deadline - now;

            const el = document.getElementById('countdown-to-deadline');
            if (!el) return;

            if (timeLeft <= 0) {
                el.innerHTML = "Time's up!";
                // auto-save whiteboards and submit if active form exists
                const activeForm = document.getElementById('testForm') || document.getElementById('pdfForm');
                if (activeForm) {
                    if (typeof saveAllWhiteboards === 'function') saveAllWhiteboards();
                    activeForm.submit();
                } else {
                    setTimeout(() => window.location.reload(true), 1000);
                }
                return;
            }

            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            el.innerHTML = `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
        }

        updateDeadlineCountdown();
        setInterval(updateDeadlineCountdown, 1000);
    @endif

    // Prevent submission when not active
    @if(!$testActive)
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // If form exists but test is not active, block client-side submissions
                e.preventDefault();
                alert('Test submission is currently disabled. Please wait until the test starts.');
                return false;
            });
        });
    @endif
});
</script>
@endsection
