@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ $test->title }}</h2>
    <p><strong>Subject:</strong> {{ $test->subject->name ?? 'N/A' }}</p>
    <p><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->format('d M Y H:i') : 'Not set' }}</p>

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
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-upload"></i>
                    Submit Your Answer
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('student.tests.submit', $test->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="answer_pdf" class="form-label">
                            <strong>Upload Your Completed Answer PDF</strong>
                        </label>
                        <input type="file"
                               class="form-control"
                               id="answer_pdf"
                               name="answer_pdf"
                               accept=".pdf"
                               required>
                        <div class="form-text">
                            Upload your completed answer sheet as a PDF file (Max: 10MB)
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Submit Answer PDF
                    </button>
                </form>
            </div>
        </div>

    {{-- Regular Questions Section --}}
    @else
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
                                                   id="q{{ $question->id }}_{{ $index }}">
                                            <label for="q{{ $question->id }}_{{ $index }}" class="form-check-label">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach

                                {{-- Written --}}
                                @elseif($question->type === 'written')
                                    <textarea id="text-answer-{{ $question->id }}"
                                              name="answers[{{ $question->id }}]"
                                              class="form-control mb-2"
                                              rows="3"
                                              placeholder="Write your answer here..."></textarea>

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
                        <i class="bi bi-send"></i> Submit Test
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>

{{-- Fabric.js --}}
@if(!$test->has_pdf)
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
</style>
@endsection
