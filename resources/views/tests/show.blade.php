<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Details | TechSolve</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-dark: #2c3e50;
      --primary-medium: #34495e;
      --primary-light: #4a6572;
      --accent-blue: #3498db;
      --accent-green: #2ecc71;
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

    header {
      background: white;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    header h1 {
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 5px;
    }

    header p {
      color: var(--primary-light);
      margin-bottom: 0;
    }

    /* Card Styles */
    .card {
      background: white;
      border-radius: 12px;
      padding: 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
      border: none;
    }

    .card-header {
      background: var(--primary-dark);
      color: white;
      padding: 20px 25px;
      border-radius: 12px 12px 0 0;
      font-weight: 600;
      font-size: 1.25rem;
    }

    .card-body {
      padding: 25px;
    }

    .card-footer {
      background: #f8f9fa;
      padding: 20px 25px;
      border-radius: 0 0 12px 12px;
      border-top: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    /* Button Styles */
    .btn {
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
      border: none;
    }

    .btn-primary {
      background: var(--accent-blue);
    }

    .btn-primary:hover {
      background: #2980b9;
      transform: translateY(-2px);
    }

    .btn-secondary {
      background: var(--primary-light);
      color: white;
    }

    .btn-secondary:hover {
      background: var(--primary-medium);
      transform: translateY(-2px);
    }

    .btn-danger {
      background: #e74c3c;
      color: white;
    }

    .btn-danger:hover {
      background: #c0392b;
      transform: translateY(-2px);
    }

    /* Questions Section */
    .questions-section {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .questions-section h3 {
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .question-item {
      margin-bottom: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid #f0f0f0;
    }

    .question-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .question-text {
      font-weight: 600;
      margin-bottom: 8px;
    }

    .question-meta {
      color: var(--primary-light);
      font-size: 0.9rem;
      margin-bottom: 10px;
    }

    .options-list {
      list-style: none;
      padding: 0;
      margin: 10px 0 0 0;
    }

    .options-list li {
      padding: 8px 12px;
      background: #f8f9fa;
      border-radius: 4px;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
    }

    .correct-option {
      background: rgba(46, 204, 113, 0.15) !important;
      border-left: 3px solid var(--accent-green);
    }

    /* Students Section */
    .students-section {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .students-section h3 {
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .student-item {
      padding: 12px 15px;
      border-bottom: 1px solid #f0f0f0;
      display: flex;
      justify-content: space-between;
    }

    .student-item:last-child {
      border-bottom: none;
    }

    .student-name {
      font-weight: 500;
    }

    .student-email {
      color: var(--primary-light);
      font-size: 0.9rem;
    }

    .no-content {
      text-align: center;
      padding: 30px;
      color: var(--primary-light);
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

      .card-footer {
        flex-direction: column;
        align-items: stretch;
      }

      .card-footer .btn {
        margin-bottom: 10px;
        width: 100%;
        text-align: center;
      }

      .card-footer form {
        width: 100%;
      }

      .card-footer .btn:last-child {
        margin-bottom: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo">
      <h2>Teacher Panel</h2>
    </div>
    <ul>
       <li><a href="{{ route('tests.create') }}"><i class="bi bi-journal-plus"></i> <span>Create Test</span></a></li>
  <li><a href="{{ route('tests.index') }}"><i class="bi bi-journal-text"></i> <span>Manage Tests</span></a></li>
      <li><a href="#"><i class="bi bi-calendar-event"></i> <span>Schedule Test</span></a></li>
      <li><a href="#"><i class="bi bi-check-square"></i> <span>Auto-Grade</span></a></li>
      <li><a href="#"><i class="bi bi-pencil-square"></i> <span>Grade Answers</span></a></li>
      <li><a href="#"><i class="bi bi-graph-up"></i> <span>Publish Results</span></a></li>
      <li><a href="#"><i class="bi bi-people"></i> <span>Student Performance</span></a></li>
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
    <header>
      <h1>Test Details <span class="wave">📝</span></h1>
      <p>View and manage test information, questions, and assigned students.</p>
    </header>

    <!-- Test Details Card -->
    <div class="card">
      <div class="card-header">
        {{ $test->title }}
      </div>
      <div class="card-body">
        <p><strong>Subject:</strong> {{ $test->subject->name ?? 'N/A' }}</p>
        <p><strong>Deadline:</strong> {{ $test->scheduled_at ? $test->scheduled_at->format('d M Y H:i') : 'Not set' }}</p>
        <p><strong>Created At:</strong> {{ $test->created_at ? $test->created_at->format('d M Y H:i') : 'N/A' }}</p>
      </div>
      <div class="card-footer">
        <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this test?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">Back to Tests</a>
      </div>
    </div>

    <!-- Questions Section -->
    <div class="questions-section">
      <h3>Questions</h3>
      @if($test->questions->count())
        @foreach($test->questions as $question)
          <div class="question-item">
            <div class="question-text">{{ $loop->iteration }}. {{ $question->question_text }}</div>
            <div class="question-meta">{{ ucfirst($question->type) }}, {{ $question->marks }} marks</div>

            @if($question->type === 'mcq' && $question->options)
              <ul class="options-list">
                @foreach(json_decode($question->options) as $index => $option)
                  <li class="{{ $index == $question->correct_answer ? 'correct-option' : '' }}">
                    {{ $option }}
                    @if($index == $question->correct_answer)
                      <span style="margin-left: auto;">✅ Correct</span>
                    @endif
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        @endforeach
      @else
        <div class="no-content">
          <i class="bi bi-question-circle" style="font-size: 2rem;"></i>
          <p>No questions added for this test yet.</p>
        </div>
      @endif
    </div>

    <!-- Assigned Students Section -->
    @if(!empty($students) && count($students))
      <div class="students-section">
        <h3>Assigned Students</h3>
        @foreach($students as $student)
          <div class="student-item">
            <div>
              <div class="student-name">{{ $student->name }}</div>
              <div class="student-email">{{ $student->email }}</div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
