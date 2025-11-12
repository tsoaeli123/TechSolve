<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard | TechSolve Online Learning</title>
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
      --accent-red: #e74c3c;
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

    /* Cards Section */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      border: none;
      height: 100%;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 15px;
      font-size: 1.25rem;
    }

    .card p {
      color: var(--primary-light);
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .card-icon {
      font-size: 2rem;
      color: var(--accent-blue);
      margin-bottom: 15px;
    }

    .btn-card {
      background: var(--accent-green);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
      width: 100%;
    }

    .btn-card:hover {
      background: #27ae60;
      transform: translateY(-2px);
    }

    /* Stats Section */
    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      text-align: center;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--accent-blue);
      margin-bottom: 5px;
    }

    .stat-label {
      color: var(--primary-light);
      font-size: 0.9rem;
    }

    /* Activity List */
    .activity-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .activity-item {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .activity-content {
      flex: 1;
    }

    .activity-content span {
      display: block;
      font-weight: 500;
    }

    .activity-content small {
      color: var(--primary-light);
    }

    /* Material Cards */
    .material-card {
      border-left: 4px solid var(--accent-blue);
      transition: transform 0.2s;
    }
    .material-card.video {
      border-left-color: var(--accent-red);
    }
    .material-card.link {
      border-left-color: var(--accent-green);
    }
    .material-card:hover {
      transform: translateY(-2px);
    }
    .badge-file { background-color: var(--accent-blue); }
    .badge-video { background-color: var(--accent-red); }
    .badge-link { background-color: var(--accent-green); }

    /* Modal Styles */
    .modal-content {
      border-radius: 12px;
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
      background: var(--primary-dark);
      color: white;
      border-radius: 12px 12px 0 0;
      padding: 20px 25px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-title {
      font-weight: 600;
    }

    .modal-body {
      padding: 25px;
    }

    .form-label {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 8px;
    }

    .form-control, .form-select {
      border-radius: 8px;
      padding: 10px 15px;
      border: 1px solid #e0e0e0;
      transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .file-upload-area {
      border: 2px dashed #e0e0e0;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      transition: all 0.3s;
      cursor: pointer;
      background-color: #f8f9fa;
    }

    .file-upload-area:hover {
      border-color: var(--accent-blue);
      background-color: #f0f8ff;
    }

    .file-upload-area i {
      font-size: 2.5rem;
      color: var(--accent-blue);
      margin-bottom: 15px;
    }

    .file-upload-area p {
      margin-bottom: 0;
      color: var(--primary-light);
    }

    .file-upload-area input {
      display: none;
    }

    .selected-file {
      margin-top: 15px;
      padding: 10px 15px;
      background-color: #e8f5e9;
      border-radius: 6px;
      border-left: 4px solid var(--accent-green);
    }

    .selected-file p {
      margin-bottom: 0;
      color: var(--primary-dark);
    }

    .btn-primary {
      background: var(--accent-blue);
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background: #2980b9;
      transform: translateY(-2px);
    }

    .class-checkbox-group {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 10px;
      margin-top: 10px;
    }

    .class-checkbox {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Materials Grid */
    .materials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    /* Error Messages */
    .alert {
      border-radius: 8px;
      border: none;
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

      .cards {
        grid-template-columns: 1fr;
      }

      .materials-grid {
        grid-template-columns: 1fr;
      }

      .menu-toggle {
        display: block;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1001;
        background: var(--primary-dark);
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 12px;
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

      <!-- Materials Management -->
      <li><a href="#" data-bs-toggle="modal" data-bs-target="#shareMaterialModal"><i class="bi bi-share"></i> <span>Share Material</span></a></li>

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
      <h1>Hello, {{ Auth::user()->name }} <span class="wave">👋</span></h1>
      <p>Manage your tests, share materials, and monitor student performance efficiently.</p>
    </header>

    <!-- Display Success/Error Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Please fix the following errors:
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Stats Section -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-number">5</div>
        <div class="stat-label">Active Tests</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">142</div>
        <div class="stat-label">Students</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">87%</div>
        <div class="stat-label">Average Completion</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">12</div>
        <div class="stat-label">Shared Materials</div>
      </div>
    </div>

    <!-- Cards Section -->
    <section class="cards">
      <div class="card">
        <div class="card-icon">
          <i class="bi bi-journal-plus"></i>
        </div>
        <h3>Create & Assign Test</h3>
        <p>Build tests with objective & subjective questions for your students.</p>
        <button class="btn-card">Create Test</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-calendar-event"></i>
        </div>
        <h3>Schedule Deadlines</h3>
        <p>Set durations and deadlines for upcoming tests effortlessly.</p>
        <button class="btn-card">Schedule</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-check-square"></i>
        </div>
        <h3>Grade & Publish Results</h3>
        <p>Auto-grade objective questions and manually grade subjective ones.</p>
        <button class="btn-card">Manage Results</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-graph-up"></i>
        </div>
        <h3>Student Performance</h3>
        <p>Track scores and progress of your students at a glance.</p>
        <button class="btn-card">View Reports</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-bell"></i>
        </div>
        <h3>Student Announcements</h3>
        <p>Post students announcements here.</p>
        <a href="{{route('teacher.announcements')}}" style="text-decoration:none; text-align:center;" class="btn-card">Announcements</a>
      </div>

      <!-- Share Material Card -->
      <div class="card">
        <div class="card-icon">
          <i class="bi bi-share"></i>
        </div>
        <h3>Share Learning Materials</h3>
        <p>Upload and share documents, videos, and links with your students.</p>
        <button class="btn-card" data-bs-toggle="modal" data-bs-target="#shareMaterialModal">Share Material</button>
      </div>
    </section>

    <!-- Recent Materials Section -->
    <div class="card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Recent Materials</h3>
        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
      </div>

      <div class="text-center py-4">
        <i class="bi bi-folder-x text-muted" style="font-size: 2rem;"></i>
        <p class="text-muted mt-2 mb-0">No materials shared yet</p>
        <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#shareMaterialModal">
          Share Your First Material
        </button>
      </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="card">
      <h3>Recent Activity</h3>
      <div class="activity-list">
        <div class="activity-item">
          <i class="bi bi-plus-circle-fill text-success"></i>
          <div class="activity-content">
            <span>Created "Mathematics Midterm Test"</span>
            <small>2 hours ago</small>
          </div>
        </div>
        <div class="activity-item">
          <i class="bi bi-check-circle-fill text-primary"></i>
          <div class="activity-content">
            <span>Graded "Science Quiz" submissions</span>
            <small>Yesterday</small>
          </div>
        </div>
        <div class="activity-item">
          <i class="bi bi-calendar-event text-warning"></i>
          <div class="activity-content">
            <span>Scheduled "History Assignment" deadline</span>
            <small>2 days ago</small>
          </div>
        </div>
        <div class="activity-item">
          <i class="bi bi-share-fill text-info"></i>
          <div class="activity-content">
            <span>Shared learning materials with students</span>
            <small>Last week</small>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Share Material Modal -->
  <div class="modal fade" id="shareMaterialModal" tabindex="-1" aria-labelledby="shareMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shareMaterialModalLabel">Share Learning Material</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="shareMaterialForm" action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label for="materialType" class="form-label">Material Type *</label>
              <select class="form-select" id="materialType" name="material_type" required>
                <option value="">Select Material Type</option>
                <option value="file" {{ old('material_type') == 'file' ? 'selected' : '' }}>Document/File</option>
                <option value="video" {{ old('material_type') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="link" {{ old('material_type') == 'link' ? 'selected' : '' }}>External Link</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="materialTitle" class="form-label">Material Title *</label>
              <input type="text" class="form-control" id="materialTitle" name="title" placeholder="Enter a descriptive title for your material" value="{{ old('title') }}" required>
            </div>

            <div class="mb-4">
              <label for="materialDescription" class="form-label">Description</label>
              <textarea class="form-control" id="materialDescription" name="description" rows="3" placeholder="Add a brief description of the material">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
              <label class="form-label">Select Class(es) *</label>
              <div class="class-checkbox-group" id="classSelection">
                @php
                  $classes = \App\Models\User::where('role', 'student')
                            ->whereNotNull('class_grade')
                            ->distinct()
                            ->pluck('class_grade')
                            ->sort();
                @endphp

                @foreach($classes as $class)
                  <div class="class-checkbox">
                    <input type="checkbox" id="class_{{ $loop->index }}" name="classes[]" value="{{ $class }}" class="form-check-input"
                      {{ is_array(old('classes')) && in_array($class, old('classes')) ? 'checked' : '' }}>
                    <label for="class_{{ $loop->index }}" class="form-check-label">{{ $class }}</label>
                  </div>
                @endforeach

                @if($classes->isEmpty())
                  <p class="text-muted">No student classes found in the database.</p>
                @endif
              </div>
            </div>

            <!-- File Upload Section -->
            <div class="mb-4 material-type-content" id="fileTypeContent" style="display: none;">
              <label class="form-label">Upload Document *</label>
              <div class="file-upload-area" id="fileUploadArea">
                <i class="bi bi-cloud-arrow-up"></i>
                <p>Drag & drop your files here or click to browse</p>
                <p class="small">Supported: PDF, Word, Excel, PowerPoint, Images</p>
                <p class="small">Maximum file size: 50MB</p>
                <input type="file" id="materialFile" name="material_file">
              </div>
              <div id="selectedFiles" class="mt-3"></div>
            </div>

            <!-- Video Upload Section -->
            <div class="mb-4 material-type-content" id="videoTypeContent" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Upload Video File</label>
                  <div class="file-upload-area" id="videoUploadArea">
                    <i class="bi bi-camera-video"></i>
                    <p>Drag & drop video files here or click to browse</p>
                    <p class="small">Supported: MP4, AVI, MOV, WMV</p>
                    <p class="small">Maximum file size: 100MB</p>
                    <input type="file" id="videoFile" name="video_file" accept="video/*">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="videoEmbedCode" class="form-label">Or Embed Video Code</label>
                  <textarea class="form-control" id="videoEmbedCode" name="video_embed_code" rows="4" placeholder="Paste embed code from YouTube, Vimeo, etc.">{{ old('video_embed_code') }}</textarea>
                  <small class="text-muted">You can upload a video file OR provide an embed code (at least one is required)</small>
                </div>
              </div>
              <div id="selectedVideos" class="mt-3"></div>
            </div>

            <!-- Link Section -->
            <div class="mb-4 material-type-content" id="linkTypeContent" style="display: none;">
              <label for="resourceLink" class="form-label">Resource Link *</label>
              <input type="url" class="form-control" id="resourceLink" name="resource_link" placeholder="https://example.com/resource" value="{{ old('resource_link') }}">
              <small class="text-muted">Enter a valid URL to external learning resources</small>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Share Material</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Material type switching
      const materialType = document.getElementById('materialType');
      const typeContents = document.querySelectorAll('.material-type-content');

      // Function to show/hide content based on selected type
      function updateMaterialTypeContent() {
        // Hide all content first
        typeContents.forEach(content => {
          content.style.display = 'none';
          content.querySelectorAll('input, textarea, select').forEach(input => {
            input.removeAttribute('required');
          });
        });

        // Show selected content
        const selectedType = materialType.value;
        if (selectedType) {
          const selectedContent = document.getElementById(selectedType + 'TypeContent');
          if (selectedContent) {
            selectedContent.style.display = 'block';
            // Add required attributes to necessary fields
            if (selectedType === 'file') {
              document.getElementById('materialFile').setAttribute('required', 'required');
            } else if (selectedType === 'link') {
              document.getElementById('resourceLink').setAttribute('required', 'required');
            }
          }
        }
      }

      // Initialize on page load
      updateMaterialTypeContent();

      // Update when selection changes
      materialType.addEventListener('change', updateMaterialTypeContent);

      // File upload functionality
      const fileUploadArea = document.getElementById('fileUploadArea');
      const materialFileInput = document.getElementById('materialFile');
      const selectedFilesContainer = document.getElementById('selectedFiles');

      // Video upload functionality
      const videoUploadArea = document.getElementById('videoUploadArea');
      const videoFileInput = document.getElementById('videoFile');
      const selectedVideosContainer = document.getElementById('selectedVideos');

      // Click on upload areas to trigger file inputs
      if (fileUploadArea) {
        fileUploadArea.addEventListener('click', function() {
          materialFileInput.click();
        });
      }

      if (videoUploadArea) {
        videoUploadArea.addEventListener('click', function() {
          videoFileInput.click();
        });
      }

      // Handle file selection
      if (materialFileInput) {
        materialFileInput.addEventListener('change', function() {
          updateSelectedFiles();
        });
      }

      if (videoFileInput) {
        videoFileInput.addEventListener('change', function() {
          updateSelectedVideos();
        });
      }

      // Drag and drop functionality for files
      if (fileUploadArea) {
        fileUploadArea.addEventListener('dragover', function(e) {
          e.preventDefault();
          fileUploadArea.style.borderColor = '#3498db';
          fileUploadArea.style.backgroundColor = '#f0f8ff';
        });

        fileUploadArea.addEventListener('dragleave', function() {
          fileUploadArea.style.borderColor = '#e0e0e0';
          fileUploadArea.style.backgroundColor = '#f8f9fa';
        });

        fileUploadArea.addEventListener('drop', function(e) {
          e.preventDefault();
          fileUploadArea.style.borderColor = '#e0e0e0';
          fileUploadArea.style.backgroundColor = '#f8f9fa';

          if (e.dataTransfer.files.length) {
            materialFileInput.files = e.dataTransfer.files;
            updateSelectedFiles();
          }
        });
      }

      // Drag and drop functionality for videos
      if (videoUploadArea) {
        videoUploadArea.addEventListener('dragover', function(e) {
          e.preventDefault();
          videoUploadArea.style.borderColor = '#3498db';
          videoUploadArea.style.backgroundColor = '#f0f8ff';
        });

        videoUploadArea.addEventListener('dragleave', function() {
          videoUploadArea.style.borderColor = '#e0e0e0';
          videoUploadArea.style.backgroundColor = '#f8f9fa';
        });

        videoUploadArea.addEventListener('drop', function(e) {
          e.preventDefault();
          videoUploadArea.style.borderColor = '#e0e0e0';
          videoUploadArea.style.backgroundColor = '#f8f9fa';

          if (e.dataTransfer.files.length) {
            videoFileInput.files = e.dataTransfer.files;
            updateSelectedVideos();
          }
        });
      }

      // Update selected files display
      function updateSelectedFiles() {
        selectedFilesContainer.innerHTML = '';

        if (!materialFileInput.files || materialFileInput.files.length === 0) {
          return;
        }

        const filesList = document.createElement('div');
        filesList.className = 'selected-file';

        let filesHTML = '<p><strong>Selected file:</strong></p><ul class="mb-0">';

        for (let i = 0; i < materialFileInput.files.length; i++) {
          const file = materialFileInput.files[i];
          filesHTML += `<li>${file.name} (${formatFileSize(file.size)})</li>`;
        }

        filesHTML += '</ul>';
        filesList.innerHTML = filesHTML;
        selectedFilesContainer.appendChild(filesList);
      }

      // Update selected videos display
      function updateSelectedVideos() {
        selectedVideosContainer.innerHTML = '';

        if (!videoFileInput.files || videoFileInput.files.length === 0) {
          return;
        }

        const videosList = document.createElement('div');
        videosList.className = 'selected-file';

        let videosHTML = '<p><strong>Selected video:</strong></p><ul class="mb-0">';

        for (let i = 0; i < videoFileInput.files.length; i++) {
          const file = videoFileInput.files[i];
          videosHTML += `<li>${file.name} (${formatFileSize(file.size)})</li>`;
        }

        videosHTML += '</ul>';
        videosList.innerHTML = videosHTML;
        selectedVideosContainer.appendChild(videosList);
      }

      // Format file size
      function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
      }

      // Form validation
      document.getElementById('shareMaterialForm').addEventListener('submit', function(e) {
        const materialType = document.getElementById('materialType').value;
        const title = document.getElementById('materialTitle').value;
        const selectedClasses = document.querySelectorAll('input[name="classes[]"]:checked');

        // Basic validation
        if (!title.trim()) {
          e.preventDefault();
          alert('Please enter a title for the material');
          return;
        }

        if (selectedClasses.length === 0) {
          e.preventDefault();
          alert('Please select at least one class');
          return;
        }

        // Type-specific validation
        if (materialType === 'file') {
          const file = materialFileInput.files[0];
          if (!file) {
            e.preventDefault();
            alert('Please select a file to upload');
            return;
          }

          // File size validation (50MB limit)
          if (file.size > 50 * 1024 * 1024) {
            e.preventDefault();
            alert('File size exceeds 50MB limit. Please choose a smaller file.');
            return;
          }
        } else if (materialType === 'video') {
          const videoFile = videoFileInput.files[0];
          const embedCode = document.getElementById('videoEmbedCode').value.trim();

          // For video, either file OR embed code is required
          if (!videoFile && !embedCode) {
            e.preventDefault();
            alert('Please either upload a video file or provide an embed code');
            return;
          }

          if (videoFile && videoFile.size > 100 * 1024 * 1024) {
            e.preventDefault();
            alert('Video file size exceeds 100MB limit. Please choose a smaller file.');
            return;
          }
        } else if (materialType === 'link') {
          const link = document.getElementById('resourceLink').value.trim();
          if (!link) {
            e.preventDefault();
            alert('Please enter a resource link');
            return;
          }

          // Basic URL validation
          try {
            new URL(link);
          } catch (_) {
            e.preventDefault();
            alert('Please enter a valid URL');
            return;
          }
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sharing...';
        submitBtn.disabled = true;
      });
    });
  </script>
</body>
</html>
