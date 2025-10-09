<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Results | TechSolve</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-dark: #2c3e50;
      --primary-medium: #34495e;
      --primary-light: #4a6572;
      --accent-blue: #3498db;
      --accent-green: #2ecc71;
      --accent-orange: #e67e22;
      --sidebar-width: 250px;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
      color: #333;
    }

    /* Sidebar Styles */
    .sidebar {
      width: var(--sidebar-width);
      background: var(--primary-dark);
      color: white;
      padding: 0;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
      transition: all 0.3s;
      z-index: 1000;
    }

    .sidebar-header {
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-bottom: 10px;
      border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar h2 {
      font-size: 1.2rem;
      margin: 0;
      font-weight: 600;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar li {
      margin: 0;
    }

    .sidebar a, .sidebar button {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: all 0.3s;
      border-left: 4px solid transparent;
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
    }

    .sidebar a:hover, .sidebar a.active, .sidebar button:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border-left: 4px solid var(--accent-green);
    }

    .sidebar i {
      margin-right: 12px;
      font-size: 1.1rem;
      width: 20px;
      text-align: center;
    }

    /* Main Content Styles */
    .main-content {
      flex: 1;
      margin-left: var(--sidebar-width);
      padding: 20px;
      transition: all 0.3s;
    }

    /* Header Styles */
    .page-header {
      background: white;
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .page-header h1 {
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 5px;
    }

    .page-header p {
      color: var(--primary-light);
      margin-bottom: 0;
    }

    /* Card Styles */
    .card {
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      margin-bottom: 20px;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      border-radius: 12px 12px 0 0 !important;
      padding: 20px;
    }

    /* Subject Card Styles */
    .subject-card {
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid transparent;
      height: 100%;
    }

    .subject-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
      border-color: var(--accent-blue);
    }

    .subject-icon {
      color: var(--accent-blue);
      margin-bottom: 15px;
    }

    /* Progress Bar Styles */
    .progress {
      height: 8px;
      border-radius: 10px;
      background-color: #e9ecef;
    }

    .progress-bar {
      border-radius: 10px;
      transition: width 0.6s ease;
    }

    /* Badge Styles */
    .badge {
      border-radius: 12px;
      font-weight: 600;
      padding: 8px 16px;
      font-size: 0.85rem;
    }

    /* Button Styles */
    .btn {
      border-radius: 25px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: 2px solid transparent;
      padding: 8px 20px;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Question Item Styles */
    .question-item {
      background: #ffffff;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid transparent;
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 20px;
    }

    .question-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
      border-color: #e9ecef;
    }

    .question-number {
      font-size: 1.1rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: white;
    }

    /* Alert Styles */
    .alert {
      border-radius: 12px;
      border: none;
      padding: 20px;
    }

    /* Score Display */
    .score-display {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border: 2px solid #e9ecef;
      border-radius: 25px;
      padding: 12px 20px;
      font-weight: bold;
    }

    /* Animation */
    @keyframes highlight {
      0% { background-color: transparent; }
      50% { background-color: #fff3cd; }
      100% { background-color: transparent; }
    }

    .highlight {
      animation: highlight 2s ease-in-out;
    }

    /* Print Styles */
    @media print {
      .sidebar, .btn, .card-header .btn {
        display: none !important;
      }
      .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
      }
      .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
      }
      .question-item:hover {
        transform: none !important;
        box-shadow: none !important;
      }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .sidebar {
        width: 70px;
        text-align: center;
      }
      .sidebar-header h2, .sidebar span {
        display: none;
      }
      .sidebar i {
        margin-right: 0;
        font-size: 1.3rem;
      }
      .main-content {
        margin-left: 70px;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 0;
        overflow: hidden;
      }
      .main-content {
        margin-left: 0;
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo">
      <h2>Student Panel</h2>
    </div>
    <ul>
      <li><a href="{{ route('student.dashboard') }}"><i class="bi bi-house"></i> <span>Dashboard</span></a></li>
      <li><a href="{{ route('student.results') }}" class="active"><i class="bi bi-trophy"></i> <span>My Results</span></a></li>
      <li><a href="#"><i class="bi bi-journal-text"></i> <span>Active Tests</span></a></li>
      <li><a href="{{ route('student.report') }}"><i class="bi bi-graph-up"></i> <span>Performance Report</span></a></li>
      <li><a href="#"><i class="bi bi-clock-history"></i> <span>Test History</span></a></li>
      <li><a href="#"><i class="bi bi-person"></i> <span>Profile</span></a></li>
      <li>
        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
          </button>
        </form>
      </li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Header -->
    <div class="page-header">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <i class="fas fa-trophy fa-2x text-primary me-3"></i>
          <div>
            <h1 class="mb-1">My Test Results</h1>
            <p class="mb-0">
              @if(isset($selectedSubject) && $selectedSubject)
                {{ $selectedSubject->name }} - Detailed Results
              @else
                View your results by subject
              @endif
            </p>
          </div>
        </div>
        <div class="d-flex gap-2">
          @if(isset($selectedSubject) && $selectedSubject)
            <a href="{{ url('/student/results') }}" class="btn btn-outline-primary">
              <i class="fas fa-arrow-left me-2"></i>All Subjects
            </a>
          @endif
          <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-home me-2"></i>Dashboard
          </a>
        </div>
      </div>
    </div>

    @if(isset($selectedSubject) && $selectedSubject)
      <!-- Subject Specific Results -->
      @if($completedTests->count() > 0)
        <div class="alert alert-info">
          <div class="d-flex align-items-center">
            <i class="fas fa-book fa-2x me-3"></i>
            <div>
              <h6 class="mb-1">{{ $selectedSubject->name }} - Results</h6>
              <small>Showing {{ $completedTests->count() }} completed test{{ $completedTests->count() > 1 ? 's' : '' }} in this subject</small>
            </div>
          </div>
        </div>

        @foreach($completedTests as $testId => $answers)
          @php
            $test = $answers->first()->test;
            $totalMarks = $answers->sum(function($answer) {
                return $answer->marks ?? $answer->score ?? 0;
            });
            $maxMarks = $answers->where(function($answer) {
                return !is_null($answer->marks) || !is_null($answer->score);
            })->count();
            $hasPdfSubmission = $answers->contains('answer', 'PDF_SUBMISSION');
            $hasMarkedPdf = $answers->contains('marked_pdf_path');
            $percentage = $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;

            if ($hasPdfSubmission && $totalMarks == 0 && $hasMarkedPdf) {
                $displayText = 'Marked on Paper';
                $badgeColor = 'bg-info';
            } else {
                $badgeColor = 'bg-success';
                if ($percentage < 50) {
                    $badgeColor = 'bg-danger';
                } elseif ($percentage < 75) {
                    $badgeColor = 'bg-warning';
                }
                $displayText = $percentage . '%';
            }
          @endphp

          <div class="card">
            <div class="card-header bg-white">
              <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                  <div class="d-flex align-items-center mb-2">
                    <h4 class="mb-0 fw-bold me-3">{{ $test->title }}</h4>
                    <span class="badge {{ $badgeColor }}">{{ $displayText }}</span>
                  </div>
                  <div class="d-flex flex-wrap gap-3 text-muted">
                    <span><i class="fas fa-book me-1"></i>{{ $test->subject->name }}</span>
                    <span><i class="fas fa-calendar me-1"></i>{{ $test->scheduled_at ? \Carbon\Carbon::parse($test->scheduled_at)->format('M j, Y') : 'Not scheduled' }}</span>
                  </div>
                </div>
                <div class="text-end">
                  @if($hasPdfSubmission && $totalMarks == 0 && $hasMarkedPdf)
                    <div class="score-display bg-info text-white">
                      <span class="fw-bold fs-5">✓</span>
                      <span class="ms-1">Paper Marked</span>
                    </div>
                  @else
                    <div class="score-display">
                      <span class="fw-bold text-primary fs-4">{{ $totalMarks }}</span>
                      <span class="text-muted">/</span>
                      <span class="fw-bold text-dark">{{ $maxMarks }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="card-body">
              <!-- Performance Summary -->
              @if(!($hasPdfSubmission && $totalMarks == 0 && $hasMarkedPdf))
              <div class="row mb-4">
                <div class="col-md-3">
                  <div class="text-center p-3 bg-light rounded-3">
                    <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                    <h6 class="mb-1">Correct Answers</h6>
                    <h4 class="text-success fw-bold">{{ $totalMarks }}</h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="text-center p-3 bg-light rounded-3">
                    <i class="fas fa-times-circle text-danger fa-2x mb-2"></i>
                    <h6 class="mb-1">Incorrect Answers</h6>
                    <h4 class="text-danger fw-bold">{{ $maxMarks - $totalMarks }}</h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="text-center p-3 bg-light rounded-3">
                    <i class="fas fa-chart-bar text-info fa-2x mb-2"></i>
                    <h6 class="mb-1">Total Questions</h6>
                    <h4 class="text-info fw-bold">{{ $maxMarks }}</h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="text-center p-3 bg-light rounded-3">
                    <i class="fas fa-percentage text-warning fa-2x mb-2"></i>
                    <h6 class="mb-1">Success Rate</h6>
                    <h4 class="text-warning fw-bold">{{ $percentage }}%</h4>
                  </div>
                </div>
              </div>
              @endif

              <!-- Timeline Info -->
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-3 bg-primary text-white rounded-3">
                    <i class="fas fa-paper-plane fa-2x me-3"></i>
                    <div>
                      <small>Submitted On</small>
                      <div class="fw-bold">{{ $answers->first()->created_at->format('M j, Y g:i A') }}</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-3 bg-success text-white rounded-3">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                      <small>Marked On</small>
                      <div class="fw-bold">
                        {{ $answers->first()->marked_at ? \Carbon\Carbon::parse($answers->first()->marked_at)->format('M j, Y g:i A') : 'Not marked' }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Quick Actions -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="p-3 bg-light rounded-3">
                    <h6 class="text-dark mb-3 fw-bold">
                      <i class="fas fa-rocket me-2"></i>Quick Actions
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                      @if($test->has_pdf && $test->pdf_path)
                        <a href="{{ route('student.tests.view-pdf', $test) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                          <i class="fas fa-file-pdf me-1"></i>View Test Questions
                        </a>
                        <a href="{{ route('tests.download.pdf', $test) }}" class="btn btn-outline-dark btn-sm">
                          <i class="fas fa-download me-1"></i>Download Test Paper
                        </a>
                      @endif
                      @if($answers->contains('marked_pdf_path'))
                        <button class="btn btn-success btn-sm" onclick="scrollToMarked()">
                          <i class="fas fa-file-signature me-1"></i>View Marked Answers
                        </button>
                      @endif
                      @if($answers->contains('comments'))
                        <button class="btn btn-info btn-sm" onclick="scrollToFeedback()">
                          <i class="fas fa-comments me-1"></i>View Teacher Feedback
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <!-- Question Details -->
              <div class="mt-4" id="questionDetails">
                <h5 class="mb-4 fw-bold">
                  <i class="fas fa-list-alt me-2"></i>Detailed Question Analysis
                </h5>

                @foreach($answers as $answer)
                  @php
                    $questionMarks = $answer->marks ?? $answer->score ?? 0;
                    $maxQuestionMarks = 1;
                    $isCorrect = $questionMarks >= $maxQuestionMarks;
                    $isPdfSubmission = $answer->answer === 'PDF_SUBMISSION';
                    $hasMarkedPdf = $answer->marked_pdf_path;
                    $hasComments = $answer->comments;
                  @endphp

                  <div class="question-item" id="question-{{ $answer->id }}"
                       data-has-marked-pdf="{{ $hasMarkedPdf ? 'true' : 'false' }}"
                       data-has-comments="{{ $hasComments ? 'true' : 'false' }}">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                      <div class="d-flex align-items-center">
                        <div class="question-number bg-{{ $isCorrect ? 'success' : ($isPdfSubmission && $hasMarkedPdf ? 'info' : 'danger') }} text-white me-3">
                          {{ $loop->iteration }}
                        </div>
                        <div>
                          <h6 class="mb-1 fw-bold">Question {{ $loop->iteration }}</h6>
                          @if($isPdfSubmission && $hasMarkedPdf)
                            <span class="badge bg-info">
                              <i class="fas fa-file-pdf me-1"></i>Marked on Paper
                            </span>
                          @else
                            <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                              {{ $questionMarks }}/{{ $maxQuestionMarks }}
                              <i class="fas {{ $isCorrect ? 'fa-check' : 'fa-times' }} ms-1"></i>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="d-flex gap-2">
                        @if($isPdfSubmission)
                          <span class="badge bg-info">
                            <i class="fas fa-file-pdf me-1"></i>PDF Submission
                          </span>
                        @elseif(str_contains($answer->answer, '[Whiteboard Answer Attached Below]'))
                          <span class="badge bg-warning">
                            <i class="fas fa-paint-brush me-1"></i>Whiteboard Answer
                          </span>
                        @else
                          <span class="badge bg-secondary">
                            <i class="fas fa-keyboard me-1"></i>Text Answer
                          </span>
                        @endif
                      </div>
                    </div>

                    <!-- Answer Analysis -->
                    <div class="answer-analysis">
                      <h6 class="text-dark mb-3 fw-bold">
                        <i class="fas fa-search me-2 text-primary"></i>Answer Analysis
                      </h6>

                      <!-- Student's Answer -->
                      <div class="mb-3">
                        <h6 class="text-dark mb-2">
                          <i class="fas fa-edit me-2 text-primary"></i>Your Submitted Answer:
                        </h6>
                        @if($isPdfSubmission)
                          <div class="mt-2">
                            @if($answer->answer_pdf_path)
                              <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('answers.download.pdf', $answer->id) }}" class="btn btn-primary btn-sm">
                                  <i class="fas fa-download me-1"></i>Download Your PDF
                                </a>
                                <a href="{{ route('answers.view.pdf', $answer->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                  <i class="fas fa-eye me-1"></i>View Your PDF
                                </a>
                              </div>
                            @else
                              <div class="alert alert-warning d-flex align-items-center rounded-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                  <strong>PDF Answer Submitted</strong>
                                  <div class="small">PDF file is currently unavailable</div>
                                </div>
                              </div>
                            @endif
                          </div>
                        @else
                          <div class="answer-content p-3 bg-light rounded-3 border">
                            @if(str_contains($answer->answer, '[Whiteboard Answer Attached Below]'))
                              <div class="whiteboard-answer text-center py-4">
                                <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                                <h6 class="text-dark mb-2">Whiteboard Answer Submitted</h6>
                                <p class="text-muted mb-0">
                                  This question was answered using the interactive whiteboard tool
                                </p>
                              </div>
                            @else
                              <div class="text-dark lh-base">
                                {{ $answer->answer }}
                              </div>
                            @endif
                          </div>
                        @endif
                      </div>

                      <!-- Marked PDF Section -->
                      @if($answer->marked_pdf_path)
                        <div class="mb-3" id="markedPdfSection">
                          <h6 class="text-dark mb-2">
                            <i class="fas fa-file-signature me-2 text-success"></i>Teacher's Marked Copy:
                          </h6>
                          <div class="marked-pdf-alert alert alert-success d-flex align-items-center rounded-3">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div class="flex-grow-1">
                              <strong>This answer has been marked on paper</strong>
                              <div class="small">Download or view the marked PDF to see corrections and feedback</div>
                            </div>
                          </div>
                          <div class="mt-3">
                            <div class="d-flex gap-2 flex-wrap">
                              <a href="{{ route('student.answers.download-marked-pdf', $answer->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download me-1"></i>Download Marked PDF
                              </a>
                              <a href="{{ route('student.answers.view-marked-pdf', $answer->id) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-eye me-1"></i>View Marked PDF
                              </a>
                            </div>
                          </div>
                        </div>
                      @endif

                      <!-- Teacher Comments -->
                      @if($answer->comments)
                        <div class="feedback-section mt-3" id="feedbackSection">
                          <h6 class="text-dark mb-2">
                            <i class="fas fa-comment-dots me-2 text-primary"></i>Detailed Teacher Feedback:
                          </h6>
                          <div class="p-4 bg-light rounded-3 border">
                            <div class="teacher-feedback-content">
                              <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-chalkboard-teacher fa-2x text-primary me-3"></i>
                                <div>
                                  <h6 class="mb-1 text-dark fw-bold">Teacher's Comments</h6>
                                  <small class="text-muted">Detailed feedback on your answer</small>
                                </div>
                              </div>
                              <div class="p-3 bg-white rounded-3 border">
                                <div class="text-dark lh-base fs-6">
                                  {!! nl2br(e($answer->comments)) !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="card text-center py-5">
          <div class="card-body">
            <div class="icon-container bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
              <i class="fas fa-clipboard-list fa-3x text-white"></i>
            </div>
            <h4 class="text-dark mb-3 fw-bold">No Results Available for {{ $selectedSubject->name }}</h4>
            <p class="text-muted mb-4">You haven't completed any tests in this subject that have been graded yet.</p>
            <a href="{{ url('/student/results') }}" class="btn btn-primary btn-lg">
              <i class="fas fa-arrow-left me-2"></i>Back to All Subjects
            </a>
          </div>
        </div>
      @endif

    @else
      <!-- Subjects Overview -->
      <div class="alert alert-info">
        <div class="d-flex align-items-center">
          <i class="fas fa-info-circle fa-2x me-3"></i>
          <div>
            <h6 class="mb-1">Results by Subject</h6>
            <small>Click on a subject to view detailed results</small>
          </div>
        </div>
      </div>

      <!-- Subjects Grid -->
      @if($subjects->count() > 0)
        <div class="row">
          @foreach($subjects as $subject)
            @php
              $subjectTests = $completedTests->filter(function($answers) use ($subject) {
                  return $answers->first()->test->subject_id == $subject->id;
              });
              $totalTests = $subjectTests->count();
              $averageScore = $subjectTests->avg(function($answers) {
                  $totalMarks = $answers->sum(function($answer) {
                      return $answer->marks ?? $answer->score ?? 0;
                  });
                  $maxMarks = $answers->where(function($answer) {
                      return !is_null($answer->marks) || !is_null($answer->score);
                  })->count();
                  return $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;
              });
              $progressClass = 'bg-success';
              if ($averageScore < 50) $progressClass = 'bg-danger';
              elseif ($averageScore < 75) $progressClass = 'bg-warning';
            @endphp

            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ url('/student/results?subject=' . $subject->id) }}" class="text-decoration-none">
                <div class="card subject-card">
                  <div class="card-body text-center p-4">
                    <div class="subject-icon mb-3">
                      <i class="fas fa-book-open fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-2">{{ $subject->name }}</h5>
                    <p class="text-muted mb-3">{{ $totalTests }} test{{ $totalTests !== 1 ? 's' : '' }} completed</p>
                    <div class="mb-3">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">Average Score</small>
                        <strong class="text-dark">{{ $averageScore }}%</strong>
                      </div>
                      <div class="progress">
                        <div class="progress-bar {{ $progressClass }}" style="width: {{ $averageScore }}%"></div>
                      </div>
                    </div>
                    <div class="mt-3">
                      <span class="badge bg-primary">
                        <i class="fas fa-eye me-1"></i>View Results
                      </span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      @else
        <div class="card text-center py-5">
          <div class="card-body">
            <div class="icon-container bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
              <i class="fas fa-clipboard-list fa-3x text-white"></i>
            </div>
            <h4 class="text-dark mb-3 fw-bold">No Results Available</h4>
            <p class="text-muted mb-4">You haven't completed any tests that have been graded yet.</p>
            <a href="{{ route('student.dashboard') }}" class="btn btn-primary btn-lg">
              <i class="fas fa-arrow-right me-2"></i>Take Your First Test
            </a>
          </div>
        </div>
      @endif
    @endif
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  function scrollToMarked() {
    const firstMarked = document.querySelector('[data-has-marked-pdf="true"]');
    if (firstMarked) {
      firstMarked.scrollIntoView({ behavior: 'smooth', block: 'start' });
      firstMarked.classList.add('highlight');
      setTimeout(() => firstMarked.classList.remove('highlight'), 2000);
    }
  }

  function scrollToFeedback() {
    const firstFeedback = document.querySelector('[data-has-comments="true"]');
    if (firstFeedback) {
      firstFeedback.scrollIntoView({ behavior: 'smooth', block: 'start' });
      firstFeedback.classList.add('highlight');
      setTimeout(() => firstFeedback.classList.remove('highlight'), 2000);
    }
  }

  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  </script>
</body>
</html>
