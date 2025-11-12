<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard | TechSolve Online Learning</title>
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
      --accent-orange: #e67e22;
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
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-card:hover {
      background: #27ae60;
      transform: translateY(-2px);
      color: white;
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
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
      transition: all 0.3s;
    }

    .activity-item:hover {
      background: #e9ecef;
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

    /* Materials Section Styles */
    .materials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .material-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      border-left: 4px solid var(--accent-blue);
    }

    .material-card.video {
      border-left-color: var(--accent-red);
    }

    .material-card.link {
      border-left-color: var(--accent-green);
    }

    .material-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .material-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
    }

    .material-title {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 5px;
      flex: 1;
    }

    .material-description {
      color: var(--primary-light);
      font-size: 0.9rem;
      margin-bottom: 15px;
    }

    .material-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.8rem;
      color: var(--primary-light);
      margin-bottom: 10px;
    }

    .material-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .btn-download {
      background: var(--accent-green);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-decoration: none;
      transition: all 0.3s;
      flex: 1;
      text-align: center;
    }

    .btn-download:hover {
      background: #27ae60;
      color: white;
    }

    .btn-view {
      background: var(--accent-blue);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-decoration: none;
      transition: all 0.3s;
      flex: 1;
      text-align: center;
    }

    .btn-view:hover {
      background: #2980b9;
      color: white;
    }

    .btn-watch {
      background: var(--accent-red);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-decoration: none;
      transition: all 0.3s;
      flex: 1;
      text-align: center;
    }

    .btn-watch:hover {
      background: #c0392b;
      color: white;
    }

    .btn-visit {
      background: var(--accent-orange);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-decoration: none;
      transition: all 0.3s;
      flex: 1;
      text-align: center;
    }

    .btn-visit:hover {
      background: #d35400;
      color: white;
    }

    .file-missing {
      background: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 5px;
      font-size: 0.9rem;
      text-align: center;
      margin-top: 10px;
    }

    .material-badge {
      font-size: 0.7rem;
      padding: 4px 8px;
    }

    .badge-file { background-color: var(--accent-blue); }
    .badge-video { background-color: var(--accent-red); }
    .badge-link { background-color: var(--accent-green); }

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

      .material-actions {
        flex-direction: column;
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
      <li><a href="{{ route('student.results') }}"><i class="bi bi-trophy"></i> <span>My Results</span></a></li>
      <li><a href="#available-tests"><i class="bi bi-journal-text"></i> <span>Active Tests</span></a></li>
      <li><a href="{{ route('student.report') }}"><i class="bi bi-graph-up"></i> <span>My Report</span></a></li>
      <li><a href="#learning-materials"><i class="bi bi-folder"></i> <span>Learning Materials</span></a></li>
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
    <header>
      <h1>Hello, {{ Auth::user()->name }} <span class="wave">👋</span></h1>
      <p>Welcome to your learning dashboard. Track your progress and access your tests.</p>
    </header>

    <!-- Stats Section -->
    <div class="stats">
      <div class="stat-card">
        <div class="stat-number">{{ $tests->count() }}</div>
        <div class="stat-label">Available Tests</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $completedTests }}</div>
        <div class="stat-label">Tests Completed</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $averageScore }}%</div>
        <div class="stat-label">Average Score</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $materials->count() }}</div>
        <div class="stat-label">Learning Materials</div>
      </div>
    </div>

    <!-- Cards Section -->
    <section class="cards">
      <div class="card">
        <div class="card-icon">
          <i class="bi bi-journal-text"></i>
        </div>
        <h3>Available Tests</h3>
        <p>Take new tests assigned by your teachers. Complete them before the deadline.</p>
        <a href="#available-tests" class="btn-card">View Tests</a>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-trophy"></i>
        </div>
        <h3>My Results</h3>
        <p>Check your marks, teacher feedback, and download marked papers.</p>
        <a href="{{ route('student.results') }}" class="btn-card">View Results</a>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-folder"></i>
        </div>
        <h3>Learning Materials</h3>
        <p>Access study materials and resources shared by your teachers.</p>
        <a href="#learning-materials" class="btn-card">View Materials</a>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-graph-up"></i>
        </div>
        <h3>Performance</h3>
        <p>Track your progress and see how you're performing across different subjects.</p>
        <a href="{{ route('student.report') }}" class="btn-card">View Report</a>
      </div>
    </section>

    <!-- Learning Materials Section -->
    <div class="card" id="learning-materials">
      <h3>Learning Materials</h3>
      @if($materials->count() > 0)
        <div class="materials-grid">
          @foreach($materials as $material)
          <div class="material-card {{ $material->material_type }}">
            <div class="material-header">
              <div class="material-title">{{ $material->title }}</div>
              <span class="badge material-badge badge-{{ $material->material_type }}">
                @if($material->material_type === 'file') Document
                @elseif($material->material_type === 'video') Video
                @elseif($material->material_type === 'link') Link
                @endif
              </span>
            </div>

            @if($material->description)
            <div class="material-description">
              {{ $material->description }}
            </div>
            @endif

            <div class="material-meta">
              <div>
                <small><i class="bi bi-person"></i>
                  @if($material->teacher)
                    {{ $material->teacher->name }}
                  @else
                    Teacher
                  @endif
                </small>
              </div>
              <div>
                <small><i class="bi bi-calendar"></i> {{ $material->created_at->format('M j, Y') }}</small>
              </div>
            </div>

            <div class="material-actions">
              @if($material->material_type === 'file')
                @php
                  $fileExists = $material->file_path && Storage::disk('public')->exists($material->file_path);
                @endphp

                @if($fileExists)
                  <a href="{{ route('material.download', $material->id) }}"
                     class="btn-download"
                     download="{{ $material->file_name }}">
                    <i class="bi bi-download"></i> Download
                  </a>
                  <a href="{{ route('material.view', $material->id) }}"
                     class="btn-view"
                     target="_blank">
                    <i class="bi bi-eye"></i> View
                  </a>
                @else
                  <div class="file-missing">
                    <i class="bi bi-exclamation-triangle"></i> File not available
                  </div>
                @endif

              @elseif($material->material_type === 'video')
                @if($material->video_path && Storage::disk('public')->exists($material->video_path))
                  <a href="{{ Storage::disk('public')->url($material->video_path) }}"
                     class="btn-watch"
                     target="_blank">
                    <i class="bi bi-play-circle"></i> Watch Video
                  </a>
                @elseif($material->video_embed_code)
                  <button class="btn-watch" onclick="showVideoModal('{{ $material->id }}')">
                    <i class="bi bi-play-circle"></i> Watch Video
                  </button>
                @else
                  <div class="file-missing">
                    <i class="bi bi-exclamation-triangle"></i> Video not available
                  </div>
                @endif

              @elseif($material->material_type === 'link')
                @if($material->resource_link)
                  <a href="{{ $material->resource_link }}"
                     class="btn-visit"
                     target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i> Visit Link
                  </a>
                @else
                  <div class="file-missing">
                    <i class="bi bi-exclamation-triangle"></i> Link not available
                  </div>
                @endif
              @endif
            </div>

            <!-- File info for documents -->
            @if($material->material_type === 'file' && $material->file_name)
            <div class="material-meta">
              <div>
                <small><i class="bi bi-file-earmark"></i> {{ $material->file_name }}</small>
              </div>
              <div>
                <small><i class="bi bi-clock"></i> {{ $material->created_at->diffForHumans() }}</small>
              </div>
            </div>
            @endif
          </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-4">
          <i class="bi bi-folder-x" style="font-size: 3rem; color: #bdc3c7;"></i>
          <p class="text-muted mt-3">No learning materials available for your class yet.</p>
          <small class="text-muted">Your teachers will share materials here when available.</small>
        </div>
      @endif
    </div>

    <!-- Available Tests Section -->
    <div class="card" id="available-tests">
      <h3>Available Tests</h3>
      @if($tests->count() > 0)
        <div class="activity-list">
          @foreach($tests as $test)
          <div class="activity-item">
            <i class="bi bi-journal-text text-primary"></i>
            <div class="activity-content">
              <span>{{ $test->title }}</span>
              <small>Subject: {{ $test->subject->title ?? 'N/A' }} • Due: {{ $test->scheduled_at->format('M j, Y') }}</small>
            </div>
            <a href="{{ route('student.tests.show', $test->id) }}" class="btn btn-primary btn-sm">
              Take Test
            </a>
          </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">No tests available at the moment.</p>
      @endif
    </div>

    <!-- Recent Activity Section -->
    <div class="card">
      <h3>Recent Activity</h3>
      <div class="activity-list">
        @if($completedTests > 0)
        <div class="activity-item">
          <i class="bi bi-check-circle-fill text-success"></i>
          <div class="activity-content">
            <span>Completed {{ $completedTests }} tests</span>
            <small>Keep up the good work!</small>
          </div>
        </div>
        @endif

        @if($pendingTests > 0)
        <div class="activity-item">
          <i class="bi bi-clock text-warning"></i>
          <div class="activity-content">
            <span>{{ $pendingTests }} tests pending</span>
            <small>Complete them before the deadline</small>
          </div>
        </div>
        @endif

        @if($materials->count() > 0)
        <div class="activity-item">
          <i class="bi bi-folder-plus text-info"></i>
          <div class="activity-content">
            <span>{{ $materials->count() }} learning materials available</span>
            <small>Check the materials section to access them</small>
          </div>
        </div>
        @endif
      </div>
    </div>
  </main>

  <!-- Video Modal -->
  <div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="videoModalTitle">Video</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="videoModalBody">
          <!-- Video content will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function showVideoModal(materialId) {
      // This would typically fetch the video embed code from the server
      // For now, we'll just show a placeholder
      const modalBody = document.getElementById('videoModalBody');
      modalBody.innerHTML = `
        <div class="text-center p-4">
          <i class="bi bi-camera-video" style="font-size: 3rem; color: #bdc3c7;"></i>
          <p class="mt-3">Video content would be embedded here.</p>
          <small class="text-muted">Embedded video player for material ID: ${materialId}</small>
        </div>
      `;

      const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
      videoModal.show();
    }
  </script>
</body>
</html>
