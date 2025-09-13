<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard | Online Exam Center</Center></title>
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

/* Body & Typography */
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    color: #fff;
    margin: 0;
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: var(--sidebar-width);
    background: rgba(44,62,80,0.95);
    backdrop-filter: blur(10px);
    padding: 0;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    box-shadow: 0 2px 20px rgba(0,0,0,0.2);
    transition: all 0.3s;
    z-index: 1000;
}

.sidebar-header {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 10px;
    border: 2px solid rgba(255,255,255,0.2);
}

.sidebar h2 {
    font-size: 1.2rem;
    margin: 0;
    font-weight: 600;
    color: #fff;
}

.sidebar a, .sidebar button {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: rgba(255,255,255,0.85);
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
    background: rgba(255,255,255,0.1);
    color: #fff;
    border-left: 4px solid var(--accent-green);
}

.sidebar i {
    margin-right: 12px;
    font-size: 1.1rem;
}

/* Main Content */
.main-content {
    flex: 1;
    margin-left: var(--sidebar-width);
    padding: 20px;
    transition: all 0.3s;
}

/* Header */
header {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

header h1 {
    font-weight: 700;
    background: linear-gradient(to right, #fff, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

header p {
    color: #dbeafe;
}

/* Cards Section */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.05);
    height: 100%;
}

.card:hover {
    transform: translateY(-8px);
    background: rgba(255,255,255,0.12);
    box-shadow: 0 12px 25px rgba(0,0,0,0.3);
}

.card h3 {
    font-weight: 600;
    margin-bottom: 15px;
    color: #fff;
}

.card p {
    color: #dbeafe;
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
    border-radius: 50px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s;
}

.btn-card:hover {
    background: #27ae60;
    transform: translateY(-3px);
}

/* Stats Section */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--accent-blue);
    margin-bottom: 5px;
}

.stat-label {
    color: #dbeafe;
}

/* Recent Activity */
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

.activity-content span {
    display: block;
    font-weight: 500;
}

.activity-content small {
    color: #dbeafe;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .sidebar { width: 70px; text-align: center; }
    .sidebar-header h2, .sidebar span { display: none; }
    .sidebar i { margin-right: 0; font-size: 1.3rem; }
    .main-content { margin-left: 70px; }
}

@media (max-width: 768px) {
    .sidebar { width: 0; overflow: hidden; }
    .main-content { margin-left: 0; padding: 15px; }
    .cards { grid-template-columns: 1fr; }
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
      <p>Manage your tests and monitor student performance efficiently.</p>
    </header>

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
        <div class="stat-number">4.2</div>
        <div class="stat-label">Avg. Rating</div>
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
    </section>

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
      </div>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
