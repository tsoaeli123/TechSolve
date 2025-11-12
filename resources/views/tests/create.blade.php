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
  <!-- MathJax -->
  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
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
      position: relative;
    }

    .mcq-options {
      background: white;
      border-radius: 6px;
      padding: 15px;
      margin-top: 10px;
      border: 1px solid #eee;
    }

    .delete-question {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #e74c3c;
      color: white;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 16px;
    }

    /* Math Input Styles */
    .math-keyboard {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 15px;
      display: none;
    }

    .math-btn {
      margin: 2px;
      min-width: 40px;
    }

    .math-preview {
      min-height: 40px;
      border: 1px dashed #ccc;
      padding: 8px;
      margin-top: 10px;
      border-radius: 4px;
      background-color: #f9f9f9;
      display: none;
    }

    .floating-math-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 24px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .toggle-math-btn {
      margin-bottom: 10px;
    }

    /* PDF Upload Styles */
    .pdf-upload-section {
      background: #f0f7ff;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid var(--accent-blue);
    }

    .upload-area {
      border: 2px dashed #3498db;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
      background: rgba(52, 152, 219, 0.05);
    }

    .upload-area:hover {
      background: rgba(52, 152, 219, 0.1);
    }

    .upload-area i {
      font-size: 48px;
      color: #3498db;
      margin-bottom: 15px;
    }

    .pdf-preview {
      margin-top: 20px;
      display: none;
    }

    .pdf-preview img {
      max-width: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .file-info {
      background: #e8f4fc;
      border-radius: 6px;
      padding: 15px;
      margin-top: 15px;
    }

    /* Option Tabs */
    .option-tabs {
      display: flex;
      margin-bottom: 20px;
      border-bottom: 1px solid #dee2e6;
    }

    .option-tab {
      padding: 12px 24px;
      background: none;
      border: none;
      font-weight: 500;
      color: var(--primary-medium);
      cursor: pointer;
      transition: all 0.3s;
      border-bottom: 3px solid transparent;
    }

    .option-tab.active {
      color: var(--accent-blue);
      border-bottom: 3px solid var(--accent-blue);
    }

    .option-tab:hover:not(.active) {
      color: var(--primary-dark);
      background-color: rgba(52, 152, 219, 0.05);
    }

    .option-content {
      display: none;
    }

    .option-content.active {
      display: block;
    }

    /* Time Fields Styling */
    .time-fields {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    @media (max-width: 768px) {
      .time-fields {
        grid-template-columns: 1fr;
      }
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
  <!-- Floating Math Button -->
  <button type="button" class="btn btn-primary floating-math-btn" id="globalMathBtn">
    ∑
  </button>

  <!-- Global Math Keyboard -->
  <div id="globalMathKeyboard" class="math-keyboard" style="position: fixed; bottom: 90px; right: 20px; width: 300px; z-index: 1000;">
    <div class="mb-2">
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="x^2">x²</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="x_1">x₁</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\sqrt{}">√</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\frac{}{}">a/b</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\pm">±</button>
    </div>
    <div class="mb-2">
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="+">+</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="-">-</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\times">×</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\div">÷</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="=">=</button>
    </div>
    <div class="mb-2">
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="(">(</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input=")">)</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\{">{</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\}">}</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\leq">≤</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\geq">≥</button>
    </div>
    <div class="mb-2">
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\alpha">α</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\beta">β</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\gamma">γ</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\theta">θ</button>
      <button type="button" class="btn btn-sm btn-secondary math-btn" data-input="\pi">π</button>
    </div>
    <div class="mt-2">
      <small class="text-muted">Click on a text field, then use these buttons to insert math symbols</small>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo">
      <h2>Teacher Panel</h2>
    </div>
    <ul>
      <li><a href="{{ route('tests.create') }}" class="active"><i class="bi bi-journal-plus"></i> <span>Create Test</span></a></li>
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
      <form action="{{ route('tests.store') }}" method="POST" id="testForm" enctype="multipart/form-data">
        @csrf
        <!-- Hidden field to track which option is selected -->
        <input type="hidden" name="question_type" id="questionType" value="manual">

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

        <!-- ADDED: Start Time and Deadline Fields -->
        <div class="mb-4">
          <div class="time-fields">
            <div>
              <label class="form-label">Start Time</label>
              <input type="datetime-local" name="start_time" class="form-control" required>
              <small class="text-muted">Students will be able to start the test from this time</small>
            </div>
            <div>
              <label class="form-label">Deadline/End Time</label>
              <input type="datetime-local" name="scheduled_at" class="form-control" required>
              <small class="text-muted">Students must submit before this time</small>
            </div>
          </div>
        </div>

        <!-- Option Selection -->
        <div class="mb-4">
          <h5 class="mb-3">How would you like to add questions?</h5>
          <div class="option-tabs">
            <button type="button" class="option-tab active" data-target="manual-questions" data-type="manual">Create Questions Manually</button>
            <button type="button" class="option-tab" data-target="pdf-upload" data-type="pdf">Upload PDF Question Paper</button>
          </div>
        </div>

        <!-- Manual Questions Section -->
        <div id="manual-questions" class="option-content active">
          <h4 class="mb-3">Questions</h4>
          <div id="questions-wrapper">
            <div class="question-group mb-4">
              <button type="button" class="delete-question" style="display: none;">×</button>
              <label>Question</label>
              <input type="text" name="questions[0][text]" class="form-control math-input" required>

              <div class="math-preview" id="preview0">
                Math preview will appear here
              </div>

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
        </div>

        <!-- PDF Upload Section -->
        <div id="pdf-upload" class="option-content">
          <div class="pdf-upload-section">
            <h5 class="mb-3">Upload Question Paper as PDF</h5>
            <div class="alert alert-info">
              <small>Upload a PDF containing all your test questions. Students will receive this PDF as their test paper.</small>
            </div>

            <div class="upload-area" id="uploadArea">
              <i class="bi bi-file-earmark-pdf"></i>
              <h5>Drag & Drop PDF Here</h5>
              <p class="text-muted">or click to browse files</p>
              <input type="file" id="pdfUpload" name="question_pdf" accept=".pdf" style="display: none;">
            </div>

            <div class="file-info" id="fileInfo" style="display: none;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 id="fileName"></h6>
                  <p class="mb-0 text-muted" id="fileSize"></p>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger" id="removeFile">Remove</button>
              </div>
            </div>

            <div class="pdf-preview" id="pdfPreview">
              <h6>PDF Preview</h6>
              <div class="alert alert-warning">
                <small>Note: Actual PDF preview requires server-side processing. This is a placeholder for demonstration.</small>
              </div>
              <div class="text-center p-4 border rounded bg-light">
                <i class="bi bi-file-earmark-pdf" style="font-size: 64px; color: #e74c3c;"></i>
                <p class="mt-2 mb-0" id="previewFileName">PDF preview would appear here</p>
              </div>
            </div>

            <!-- PDF Marks Field -->
            <div class="mt-4">
              <label class="form-label">Marks for PDF Paper</label>
              <input type="number" name="pdf_marks" class="form-control" id="pdfMarks"
                     min="1" placeholder="Enter marks for this PDF paper">
              <small class="text-muted">This will be the total marks for the PDF question paper</small>
            </div>
          </div>
        </div>

        <br><br>
        <button type="submit" class="btn btn-success">Save Test</button>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let qIndex = 1;
    let activeTextarea = null;

    // Set minimum datetime to current time
    function setMinDateTime() {
      const now = new Date();
      const localDateTime = now.toISOString().slice(0, 16);

      const startTimeInput = document.querySelector('input[name="start_time"]');
      const deadlineInput = document.querySelector('input[name="scheduled_at"]');

      if (startTimeInput) {
        startTimeInput.min = localDateTime;
      }
      if (deadlineInput) {
        deadlineInput.min = localDateTime;
      }
    }

    // Validate time fields
    function validateTimeFields() {
      const startTimeInput = document.querySelector('input[name="start_time"]');
      const deadlineInput = document.querySelector('input[name="scheduled_at"]');

      if (startTimeInput.value && deadlineInput.value) {
        const startTime = new Date(startTimeInput.value);
        const deadline = new Date(deadlineInput.value);

        if (deadline <= startTime) {
          deadlineInput.setCustomValidity('Deadline must be after start time');
        } else {
          deadlineInput.setCustomValidity('');
        }
      }
    }

    // Initialize time validation
    document.addEventListener('DOMContentLoaded', function() {
      setMinDateTime();

      const startTimeInput = document.querySelector('input[name="start_time"]');
      const deadlineInput = document.querySelector('input[name="scheduled_at"]');

      if (startTimeInput) {
        startTimeInput.addEventListener('change', validateTimeFields);
      }
      if (deadlineInput) {
        deadlineInput.addEventListener('change', validateTimeFields);
      }
    });

    // Option tabs functionality
    document.querySelectorAll('.option-tab').forEach(tab => {
      tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.option-tab').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tab
        this.classList.add('active');

        // Hide all content sections
        document.querySelectorAll('.option-content').forEach(content => {
          content.classList.remove('active');
        });

        // Show the targeted content section
        const targetId = this.getAttribute('data-target');
        document.getElementById(targetId).classList.add('active');

        // Update the hidden field with the selected option
        const questionType = this.getAttribute('data-type');
        document.getElementById('questionType').value = questionType;

        console.log('Question type set to:', questionType);

        // Remove required attribute from manual questions when PDF is selected
        if (questionType === 'pdf') {
          document.querySelectorAll('#manual-questions input, #manual-questions select').forEach(field => {
            field.removeAttribute('required');
          });
          // Add required to PDF marks
          document.getElementById('pdfMarks').setAttribute('required', 'required');
        } else {
          // Add required attribute back when manual is selected
          document.querySelectorAll('#manual-questions input[name*="[text]"], #manual-questions select[name*="[type]"], #manual-questions input[name*="[marks]"]').forEach(field => {
            field.setAttribute('required', 'required');
          });
          // Remove required from PDF marks
          document.getElementById('pdfMarks').removeAttribute('required');
        }
      });
    });

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
      newQ.querySelector('.math-preview').innerHTML = 'Math preview will appear here';

      // Show delete button for new questions (but not for the first one)
      newQ.querySelector('.delete-question').style.display = 'block';

      // Update names
      newQ.querySelector('input[name*="[text]"]').name = `questions[${qIndex}][text]`;
      newQ.querySelector('select[name*="[type]"]').name = `questions[${qIndex}][type]`;
      newQ.querySelector('input[name*="[options]"]').name = `questions[${qIndex}][options]`;
      newQ.querySelector('input[name*="[correct_answer]"]').name = `questions[${qIndex}][correct_answer]`;
      newQ.querySelector('input[name*="[marks]"]').name = `questions[${qIndex}][marks]`;

      // Update preview ID
      const preview = newQ.querySelector('.math-preview');
      preview.id = `preview${qIndex}`;

      // Add change listener
      newQ.querySelector('.question-type').addEventListener('change', e => toggleMcqOptions(e.target));

      // Add delete button listener
      newQ.querySelector('.delete-question').addEventListener('click', function() {
        this.closest('.question-group').remove();
      });

      // Add math input listeners
      const mathInput = newQ.querySelector('.math-input');
      mathInput.addEventListener('focus', function() {
        activeTextarea = this;
        const previewId = 'preview' + this.name.match(/\[(\d+)\]/)[1];
        const preview = document.getElementById(previewId);
        if (preview) {
          preview.style.display = 'block';
        }
      });

      mathInput.addEventListener('input', function() {
        const questionId = this.name.match(/\[(\d+)\]/)[1];
        updatePreview(this.id, `preview${questionId}`);
      });

      wrapper.appendChild(newQ);
      qIndex++;
    });

    // Set active textarea when focused
    document.querySelectorAll('.math-input').forEach(textarea => {
      textarea.addEventListener('focus', function() {
        activeTextarea = this;
        const questionId = this.name.match(/\[(\d+)\]/)[1];
        const preview = document.getElementById(`preview${questionId}`);
        if (preview) {
          preview.style.display = 'block';
        }
      });
    });

    // Toggle global math keyboard
    document.getElementById('globalMathBtn').addEventListener('click', function() {
      const keyboard = document.getElementById('globalMathKeyboard');
      keyboard.style.display = keyboard.style.display === 'none' ? 'block' : 'none';
    });

    // Math keyboard button functionality
    document.querySelectorAll('.math-btn').forEach(button => {
      button.addEventListener('click', function() {
        if (!activeTextarea) {
          alert('Please click on a question text field first');
          return;
        }

        const inputValue = this.getAttribute('data-input');

        // Get current cursor position
        const start = activeTextarea.selectionStart;
        const end = activeTextarea.selectionEnd;
        const text = activeTextarea.value;

        // Insert the math symbol at cursor position
        activeTextarea.value = text.substring(0, start) + inputValue + text.substring(end);

        // Move cursor after the inserted text
        activeTextarea.selectionStart = activeTextarea.selectionEnd = start + inputValue.length;

        // Focus back on the textarea
        activeTextarea.focus();

        // Update preview
        const questionId = activeTextarea.name.match(/\[(\d+)\]/)[1];
        updatePreview(activeTextarea.id, `preview${questionId}`);
      });
    });

    // Update math preview as user types
    document.querySelectorAll('.math-input').forEach(textarea => {
      textarea.addEventListener('input', function() {
        const questionId = this.name.match(/\[(\d+)\]/)[1];
        updatePreview(this.id, `preview${questionId}`);
      });
    });

    // Function to update math preview
    function updatePreview(textareaId, previewId) {
      const textarea = document.getElementById(textareaId);
      const preview = document.getElementById(previewId);

      if (!textarea || !preview) return;

      let text = textarea.value;

      // Simple conversion: wrap content in \( \) for preview
      if (text.trim()) {
        preview.innerHTML = `\\(${text}\\)`;
      } else {
        preview.innerHTML = 'Math preview will appear here';
      }

      // Re-render MathJax
      if (window.MathJax) {
        MathJax.typesetPromise([preview]).catch(err => {
          console.error('MathJax typeset error:', err);
        });
      }
    }

    // Initialize previews for existing questions
    document.querySelectorAll('.math-input').forEach(textarea => {
      const questionId = textarea.name.match(/\[(\d+)\]/)[1];
      updatePreview(textarea.id, `preview${questionId}`);
    });

    // PDF Upload Functionality
    const uploadArea = document.getElementById('uploadArea');
    const pdfUpload = document.getElementById('pdfUpload');
    const fileInfo = document.getElementById('fileInfo');
    const pdfPreview = document.getElementById('pdfPreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const previewFileName = document.getElementById('previewFileName');
    const removeFile = document.getElementById('removeFile');
    const pdfMarks = document.getElementById('pdfMarks');

    // Click on upload area to trigger file input
    uploadArea.addEventListener('click', () => {
      pdfUpload.click();
    });

    // Handle file selection
    pdfUpload.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        handleFileSelection(file);
      }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadArea.style.backgroundColor = 'rgba(52, 152, 219, 0.2)';
      uploadArea.style.borderColor = '#2980b9';
    });

    uploadArea.addEventListener('dragleave', () => {
      uploadArea.style.backgroundColor = 'rgba(52, 152, 219, 0.05)';
      uploadArea.style.borderColor = '#3498db';
    });

    uploadArea.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadArea.style.backgroundColor = 'rgba(52, 152, 219, 0.05)';
      uploadArea.style.borderColor = '#3498db';

      const file = e.dataTransfer.files[0];
      if (file && file.type === 'application/pdf') {
        handleFileSelection(file);
        pdfUpload.files = e.dataTransfer.files;
      } else {
        alert('Please drop a valid PDF file');
      }
    });

    // Remove file
    removeFile.addEventListener('click', () => {
      pdfUpload.value = '';
      fileInfo.style.display = 'none';
      pdfPreview.style.display = 'none';
      uploadArea.style.display = 'block';
      pdfMarks.value = '';
    });

    // Handle file selection
    function handleFileSelection(file) {
      if (file.type !== 'application/pdf') {
        alert('Please select a PDF file');
        return;
      }

      if (file.size > 10 * 1024 * 1024) { // 10MB limit
        alert('File size must be less than 10MB');
        return;
      }

      // Update file info
      fileName.textContent = file.name;
      fileSize.textContent = `Size: ${(file.size / 1024 / 1024).toFixed(2)} MB`;

      // Update preview
      previewFileName.textContent = file.name;

      // Show file info and preview, hide upload area
      fileInfo.style.display = 'block';
      pdfPreview.style.display = 'block';
      uploadArea.style.display = 'none';

      console.log('PDF file selected:', file.name);
    }

    // Form submission validation
    document.getElementById('testForm').addEventListener('submit', function(e) {
      const questionType = document.getElementById('questionType').value;
      let isValid = true;
      let errorMessage = '';

      console.log('Form submission validation - Question type:', questionType);

      // Validate time fields
      const startTimeInput = document.querySelector('input[name="start_time"]');
      const deadlineInput = document.querySelector('input[name="scheduled_at"]');

      if (startTimeInput.value && deadlineInput.value) {
        const startTime = new Date(startTimeInput.value);
        const deadline = new Date(deadlineInput.value);

        if (deadline <= startTime) {
          isValid = false;
          errorMessage = 'Deadline must be after start time';
        }
      }

      if (questionType === 'pdf') {
        // Check if PDF is uploaded
        if (!pdfUpload.files.length) {
          isValid = false;
          errorMessage = 'Please upload a PDF file';
        }
        // Check if marks are entered for PDF
        else if (!pdfMarks.value || pdfMarks.value < 1) {
          isValid = false;
          errorMessage = 'Please enter valid marks for the PDF paper';
        } else {
          console.log('PDF file and marks validated');
        }
      } else {
        // Check if at least one question is created and has content
        const questionInputs = document.querySelectorAll('input[name^="questions"][name$="[text]"]');
        let hasValidQuestion = false;

        questionInputs.forEach(input => {
          if (input.value.trim() !== '') {
            hasValidQuestion = true;
          }
        });

        if (!hasValidQuestion) {
          isValid = false;
          errorMessage = 'Please add at least one question';
        } else {
          console.log('Manual questions validated - count:', questionInputs.length);
        }
      }

      // If validation fails, prevent submission and show alert
      if (!isValid) {
        e.preventDefault();
        alert(errorMessage);
        console.log('Form validation failed:', errorMessage);
        return false;
      }

      console.log('Form validation passed, submitting...');
      return true;
    });

    // Debug: Log form data on submit to see what's being sent
    document.getElementById('testForm').addEventListener('submit', function(e) {
      console.log('Form submitted');
      console.log('Question type:', document.getElementById('questionType').value);
      console.log('Start Time:', document.querySelector('input[name="start_time"]').value);
      console.log('Deadline:', document.querySelector('input[name="scheduled_at"]').value);
      console.log('PDF file:', pdfUpload.files[0]);
      console.log('PDF Marks:', pdfMarks.value);

      const formData = new FormData(this);
      console.log('FormData contents:');
      for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
      }
    });
  </script>
</body>
</html>
