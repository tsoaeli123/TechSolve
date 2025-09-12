<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Test | TechSolve</title>
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

    /* Sidebar */
    .sidebar {
      width: var(--sidebar-width);
      background: var(--primary-dark);
      color: white;
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

    /* Main */
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
    }

    header p {
      color: var(--primary-light);
    }

    /* Form */
    .form-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
      color: var(--primary-dark);
    }

    .form-control:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .btn-success {
      background: var(--accent-green);
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-success:hover {
      background: #27ae60;
      transform: translateY(-2px);
    }

    .btn-outline-primary {
      border: 1px solid var(--accent-blue);
      color: var(--accent-blue);
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-outline-primary:hover {
      background: var(--accent-blue);
      color: white;
      transform: translateY(-2px);
    }

    /* Question group */
    .question-group {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid var(--accent-blue);
    }

    .mcq-options {
      background: white;
      border-radius: 6px;
      padding: 15px;
      margin-top: 10px;
      border: 1px solid #eee;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar { width: 70px; text-align: center; }
      .sidebar-header h2, .sidebar span { display: none; }
      .sidebar i { margin-right: 0; font-size: 1.3rem; }
      .main-content { margin-left: 70px; }
    }

    @media (max-width: 768px) {
      .sidebar { width: 0; overflow: hidden; }
      .main-content { margin-left: 0; padding: 15px; }
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
    <ul>      <li><a href="{{ route('tests.create') }}"><i class="bi bi-journal-plus"></i> <span>Create Test</span></a></li>
  <li><a href="{{ route('tests.index') }}"><i class="bi bi-journal-text"></i> <span>Manage Tests</span></a></li>
<li>
    <a href="{{ route('teacher.profile.edit') }}">
        <i class="bi bi-calendar-event"></i>
        <span>Profile</span>
    </a>
</li>
      <li><a href="#"><i class="bi bi-check-square"></i> <span>Auto-Grade</span></a></li>
      <li><a href="#"><i class="bi bi-pencil-square"></i> <span>Grade Answers</span></a></li>
      <li><a href="#"><i class="bi bi-graph-up"></i> <span>Publish Results</span></a></li>
      <li><a href="#"><i class="bi bi-people"></i> <span>Student Performance</span></a></li>
      <li>
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
      <h1>Create New Test ➕</h1>
      <p>Build tests with objective & subjective questions for your students.</p>
    </header>

    <div class="form-container">
      <form action="{{ route('tests.store') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="form-label">Test Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Subject</label>
          <select name="subject_id" class="form-control" required>
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
              <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Deadline</label>
          <input type="datetime-local" name="scheduled_at" class="form-control" required>
        </div>

        <hr>
        <h4 class="mb-3">Questions</h4>
        <div id="questions-wrapper">
          <div class="question-group mb-4">
            <label>Question</label>
            <input type="text" name="questions[0][text]" class="form-control" required>

            <label>Type</label>
            <select name="questions[0][type]" class="form-control question-type">
              <option value="written">Written (Text)</option>
              <option value="mcq">Multiple Choice</option>
            </select>

            <label>Marks</label>
            <input type="number" name="questions[0][marks]" class="form-control" value="1" min="1">

            <div class="mcq-options mt-2" style="display:none;">
              <label>Options (comma-separated: A,B,C,D)</label>
              <input type="text" name="questions[0][options]" class="form-control" placeholder="Option1,Option2,Option3">
              <label>Correct Option Index</label>
              <input type="number" name="questions[0][correct_answer]" class="form-control" placeholder="0 for first option">
            </div>
          </div>
        </div>

        <button type="button" id="add-question" class="btn btn-outline-primary mt-2">+ Add Question</button>
        <br><br>
        <button type="submit" class="btn btn-success">Save Test</button>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let qIndex = 1;

    function toggleMcqOptions(select){
      const wrapper = select.closest('.question-group').querySelector('.mcq-options');
      wrapper.style.display = select.value === 'mcq' ? 'block' : 'none';
    }

    document.querySelectorAll('.question-type').forEach(select => {
      select.addEventListener('change', e => toggleMcqOptions(e.target));
    });

    document.getElementById('add-question').addEventListener('click', () => {
      let wrapper = document.getElementById('questions-wrapper');
      let newQ = document.querySelector('.question-group').cloneNode(true);

      // Reset values
      newQ.querySelector('input[name*="[text]"]').value = '';
      newQ.querySelector('input[name*="[options]"]').value = '';
      newQ.querySelector('input[name*="[correct_answer]"]').value = '';
      newQ.querySelector('input[name*="[marks]"]').value = '1';
      newQ.querySelector('.mcq-options').style.display = 'none';

      // Update names
      newQ.querySelector('input[name*="[text]"]').name = `questions[${qIndex}][text]`;
      newQ.querySelector('select[name*="[type]"]').name = `questions[${qIndex}][type]`;
      newQ.querySelector('input[name*="[options]"]').name = `questions[${qIndex}][options]`;
      newQ.querySelector('input[name*="[correct_answer]"]').name = `questions[${qIndex}][correct_answer]`;
      newQ.querySelector('input[name*="[marks]"]').name = `questions[${qIndex}][marks]`;

      // Add change listener
      newQ.querySelector('.question-type').addEventListener('change', e => toggleMcqOptions(e.target));

      wrapper.appendChild(newQ);
      qIndex++;
    });
  </script>
</body>
</html>
