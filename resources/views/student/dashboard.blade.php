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
      <li><a href="#"><i class="bi bi-journal-text"></i> <span>Active Tests</span></a></li>
      <a href="{{ route('student.report') }}" class="btn btn-info btn-sm">
    <i class="fas fa-chart-line me-1"></i>View My Report
</a>
      <li><a href="#"><i class="bi bi-clock-history"></i> <span>Test History</span></a></li>
      <li><a href="#"><i class="bi bi-graph-up"></i> <span>Performance</span></a></li>
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
        <div class="stat-number">{{ $averageScore }}</div>
        <div class="stat-label">Average Score</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $pendingTests }}</div>
        <div class="stat-label">Pending Tests</div>
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
          <i class="bi bi-graph-up"></i>
        </div>
        <h3>Performance</h3>
        <p>Track your progress and see how you're performing across different subjects.</p>
        <a href="#" class="btn-card">View Performance</a>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="bi bi-clock-history"></i>
        </div>
        <h3>Test History</h3>
        <p>Review all tests you've completed and see your submission history.</p>
        <a href="#" class="btn-card">View History</a>
      </div>
    </section>

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

        <div class="activity-item">
          <i class="bi bi-trophy-fill text-warning"></i>
          <div class="activity-content">
            <span>Average score: {{ $averageScore }}</span>
            <small>Your current performance</small>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
