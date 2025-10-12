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
                    Total Marks:
                    @if($test->question_type === 'pdf')
                        {{ $test->total_marks ?? 'N/A' }}
                    @else
                        {{ $answers->sum(function($answer) { return $answer->question ? $answer->question->marks : 0; }) }}
                    @endif
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
                      <form action="{{ route('submissions.grade', ['test' => $test->id, 'studentId' => $studentId]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @foreach($answers as $answer)
                                <div class="question-item mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">
                                            @if($answer->answer === 'PDF_SUBMISSION' && $answer->answer_pdf_path)
                                                <i class="bi bi-file-earmark-pdf text-danger"></i> PDF Answer Submission
                                            @else
                                                Q{{ $loop->iteration }}: {{ $answer->question ? $answer->question->question_text : 'Answer' }}
                                            @endif
                                        </h6>
                                        <span class="fw-bold">
                                            (
                                            @if($test->question_type === 'pdf')
                                                {{ $test->total_marks ?? 'N/A' }}
                                            @else
                                                {{ $answer->question ? $answer->question->marks : 'N/A' }}
                                            @endif
                                             marks )
                                        </span>
                                    </div>

                                    <div class="student-answer bg-light p-3 rounded mb-3">
                                        <strong>Student's Answer:</strong><br>

                                        {{-- PDF Answer Submission --}}
                                        @if($answer->answer === 'PDF_SUBMISSION' && $answer->answer_pdf_path)
                                            <div class="pdf-submission">
                                                <!-- PDF Embed with proper URL -->
                                                <div class="mb-3">
                                                    <h6><i class="bi bi-file-earmark-pdf"></i> Submitted PDF Answer:</h6>
                                                    <div class="pdf-embed-container border rounded bg-white">
                                                        @php
                                                            // Use the controller method to view PDF - this is the key fix!
                                                            $pdfViewUrl = route('teacher.tests.answers.view-pdf', [$test->id, $answer->id]);
                                                            $pdfDownloadUrl = route('teacher.tests.answers.download-pdf', [$test->id, $answer->id]);

                                                            // Also check if file exists for display
                                                            $fileExists = Storage::disk('public')->exists($answer->answer_pdf_path);
                                                            $directUrl = $fileExists ? Storage::disk('public')->url($answer->answer_pdf_path) : null;
                                                        @endphp

                                                        @if($fileExists)
                                                            <!-- Use the teacher PDF viewing route -->
                                                            <iframe
                                                                src="{{ $pdfViewUrl }}"
                                                                width="100%"
                                                                height="500"
                                                                style="border: none;"
                                                                title="Student's PDF Answer - {{ $answer->answer_pdf_original_name }}">
                                                                Your browser does not support PDF embedding.
                                                                <a href="{{ $pdfViewUrl }}" target="_blank">
                                                                    Click here to view the PDF
                                                                </a>
                                                            </iframe>
                                                        @else
                                                            <div class="text-center p-4">
                                                                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                                                                <p class="mt-2">PDF file not found in storage.</p>
                                                                <p class="text-muted">Path: {{ $answer->answer_pdf_path }}</p>
                                                                <div class="mt-2">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                                            onclick="debugPdfPath('{{ $answer->id }}')">
                                                                        Debug PDF Path
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- PDF Actions -->
                                                <div class="d-flex gap-2 flex-wrap mb-3">
                                                    @if($fileExists)
                                                        <!-- View in new tab using teacher route -->
                                                        <a href="{{ $pdfViewUrl }}"
                                                           target="_blank"
                                                           class="btn btn-outline-primary">
                                                            <i class="bi bi-eye"></i> Open in New Tab
                                                        </a>

                                                        <!-- Download using teacher download route -->
                                                        <a href="{{ $pdfDownloadUrl }}"
                                                           class="btn btn-success">
                                                            <i class="bi bi-download"></i> Download PDF
                                                        </a>

                                                        <!-- Full screen view -->
                                                        <button type="button" class="btn btn-info"
                                                                onclick="openFullScreenPdf('{{ $pdfViewUrl }}')">
                                                            <i class="bi bi-arrows-fullscreen"></i> Full Screen
                                                        </button>

                                                        <!-- Direct file access (fallback) -->
                                                        @if($directUrl)
                                                            <a href="{{ $directUrl }}"
                                                               target="_blank"
                                                               class="btn btn-warning">
                                                                <i class="bi bi-file-earmark"></i> Direct Access
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                            PDF file unavailable
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- File Info -->
                                                <div class="file-info p-3 bg-white border rounded">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong>File Information:</strong><br>
                                                            <small class="text-muted">
                                                                <i class="bi bi-file-earmark"></i>
                                                                Name: {{ $answer->answer_pdf_original_name ?? 'answer.pdf' }}
                                                            </small><br>
                                                            <small class="text-muted">
                                                                <i class="bi bi-clock"></i>
                                                                Submitted: {{ \Carbon\Carbon::parse($answer->submitted_at)->format('d M Y H:i') }}
                                                            </small><br>
                                                            <small class="text-muted">
                                                                <i class="bi bi-hash"></i>
                                                                Answer ID: {{ $answer->id }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Storage Info:</strong><br>
                                                            <small class="text-muted">
                                                                <i class="bi bi-folder"></i>
                                                                Path: {{ $answer->answer_pdf_path }}
                                                            </small><br>
                                                            @if($fileExists)
                                                                <small class="text-success">
                                                                    <i class="bi bi-check-circle"></i>
                                                                    File exists ({{ round(Storage::disk('public')->size($answer->answer_pdf_path) / 1024, 2) }} KB)
                                                                </small><br>
                                                                <small class="text-info">
                                                                    <i class="bi bi-link"></i>
                                                                    <a href="{{ $directUrl }}" target="_blank">Direct URL</a>
                                                                </small>
                                                            @else
                                                                <small class="text-danger">
                                                                    <i class="bi bi-exclamation-circle"></i>
                                                                    File not found in storage
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        {{-- If answer contains whiteboard (base64 image) --}}
                                        @elseif(Str::contains($answer->answer, 'data:image/png;base64'))
                                            @php
                                                // Split text + images if both exist
                                                $parts = preg_split('/(data:image\/png;base64,[A-Za-z0-9+\/=]+)/', $answer->answer, -1, PREG_SPLIT_DELIM_CAPTURE);
                                            @endphp

                                            @foreach($parts as $part)
                                                @if(Str::startsWith($part, 'data:image/png;base64'))
                                                    <div class="mt-2">
                                                        <img src="{{ $part }}" alt="Whiteboard Answer" class="img-fluid border rounded" style="max-height: 300px;">
                                                    </div>
                                                @elseif(trim($part) !== '')
                                                    <p>{{ $part }}</p>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{ $answer->answer }}</p>
                                        @endif
                                    </div>

                                    <div class="marking-section mt-2">
                                        <div class="d-flex align-items-center mb-3">
                                            <label class="me-2"><strong>Marks Awarded:</strong></label>
                                            <input type="number"
                                                   name="marks[{{ $answer->id }}]"
                                                   class="form-control marks-input me-2"
                                                   style="width: 80px;" min="0"
                                                   max="{{ $test->question_type === 'pdf' ? ($test->total_marks ?? 100) : ($answer->question ? $answer->question->marks : 100) }}"
                                                   value="{{ $answer->marks ?? '' }}"
                                                   placeholder="0">
                                            <span>/
                                                @if($test->question_type === 'pdf')
                                                    {{ $test->total_marks ?? 'N/A' }}
                                                @else
                                                    {{ $answer->question ? $answer->question->marks : 'N/A' }}
                                                @endif
                                            </span>
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
                                <small class="text-muted">Upload a marked version of the student's PDF answer</small>
                            </div>

                            <div class="total-section border-top pt-3 mt-4">
                                <h5>Total Marks:
                                    <span class="total-marks-display">0</span>
                                    /
                                    @if($test->question_type === 'pdf')
                                        {{ $test->total_marks ?? 'N/A' }}
                                    @else
                                        {{ $answers->sum(function($answer) { return $answer->question ? $answer->question->marks : 0; }) }}
                                    @endif
                                </h5>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">
                                <i class="bi bi-check-lg"></i> Submit Marks & Feedback
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle display-4"></i>
                <h4 class="mt-3">No Submissions Yet</h4>
                <p class="mb-0">Students haven't submitted any answers for this test.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Full Screen PDF Modal -->
<div class="modal fade" id="fullScreenPdfModal" tabindex="-1" aria-labelledby="fullScreenPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullScreenPdfModalLabel">PDF Answer - Full Screen View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="fullScreenPdfFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="fullScreenDownloadBtn" class="btn btn-success" download>
                    <i class="bi bi-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .printable-page { background: white; padding: 20px; }
    .marks-input { border: 2px solid #007bff; font-weight: bold; text-align: center; }
    .student-answer { border-left: 4px solid #007bff; }
    .question-item { background: #fff; }
    .pdf-submission {
        border: 2px solid #dc3545;
        border-radius: 8px;
        padding: 15px;
        background: #f8f9fa;
    }
    .pdf-embed-container {
        background: #f8f9fa;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .file-info {
        background: #e9ecef !important;
        border-radius: 5px;
    }
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; }
    }

    /* Full screen modal styling */
    .modal-fullscreen .modal-body {
        height: calc(100vh - 120px);
    }

    #fullScreenPdfFrame {
        min-height: 100%;
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

// Full screen PDF viewer
function openFullScreenPdf(pdfUrl) {
    const modal = new bootstrap.Modal(document.getElementById('fullScreenPdfModal'));
    const frame = document.getElementById('fullScreenPdfFrame');
    const downloadBtn = document.getElementById('fullScreenDownloadBtn');

    frame.src = pdfUrl;
    downloadBtn.href = pdfUrl;
    downloadBtn.download = 'student_answer.pdf';

    modal.show();
}

// Close modal when clicking outside
document.getElementById('fullScreenPdfModal').addEventListener('hidden.bs.modal', function () {
    const frame = document.getElementById('fullScreenPdfFrame');
    frame.src = '';
});

// Debug function to check PDF availability
function debugPdfPath(answerId) {
    fetch(`/debug/check-pdf-answer/${answerId}`)
        .then(response => response.text())
        .then(data => {
            console.log('PDF Debug Info:', data);
            alert('Check browser console for PDF debug information');
        })
        .catch(error => {
            console.error('Debug error:', error);
            alert('Debug failed. Check browser console.');
        });
}

// Initialize total marks on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.card').forEach(card => {
        updateTotalMarks(card);
    });
});
</script>
@endsection
