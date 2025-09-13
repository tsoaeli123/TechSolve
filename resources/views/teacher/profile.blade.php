<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Profile | Online Exam Center</title>
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

    /* Profile Card */
    .profile-card {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      margin-bottom: 25px;
      border: 1px solid rgba(255,255,255,0.05);
      transition: all 0.3s ease;
    }

    .profile-card:hover {
      transform: translateY(-5px);
      background: rgba(255,255,255,0.12);
      box-shadow: 0 12px 25px rgba(0,0,0,0.3);
    }

    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
    }

    .profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: var(--accent-blue);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: white;
      margin-right: 20px;
    }

    .profile-info h2 {
      margin: 0;
      color: #fff;
    }

    .profile-info p {
      color: #dbeafe;
      margin: 5px 0 0 0;
    }

    .profile-details {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .detail-item strong {
      display: block;
      color: #fff;
      margin-bottom: 5px;
    }

    .detail-item span {
      color: #dbeafe;
    }

    .btn-edit {
      background: var(--accent-green);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-edit:hover {
      background: #27ae60;
      transform: translateY(-3px);
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

    /* Alert */
    .alert-success {
      background: rgba(46, 204, 113, 0.2);
      color: #2ecc71;
      border: 1px solid rgba(46, 204, 113, 0.4);
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
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
      .profile-header { flex-direction: column; text-align: center; }
      .profile-avatar { margin: 0 0 15px 0; }
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
      <li><a href="{{ route('teacher.profile.edit') }}"><i class="bi bi-calendar-event"></i> <span>Profile</span></a></li>
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
      <h1>Teacher Profile <span class="wave">👤</span></h1>
      <p>View and manage your profile information.</p>
    </header>

    @if(session('success'))
      <div class="alert-success">
        {{ session('success') }}
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
        <div class="stat-number">4.2</div>
        <div class="stat-label">Avg. Rating</div>
      </div>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
      <div class="profile-header">
        <div class="profile-avatar">
          {{ substr($teacher->name, 0, 1) }}
        </div>
        <div class="profile-info">
          <h2>{{ $teacher->name }}</h2>
          <p>{{ $teacher->subject_specialization ?? 'Subject Specialist' }}</p>
        </div>
      </div>

      <div class="profile-details">
        <div class="detail-item">
          <strong>Name</strong>
          <span>{{ $teacher->name }}</span>
        </div>

        <div class="detail-item">
          <strong>Email</strong>
          <span>{{ $teacher->email }}</span>
        </div>

        <div class="detail-item">
          <strong>Subject Specialization</strong>
          <span>{{ $teacher->subject_specialization ?? 'N/A' }}</span>
        </div>

        <div class="detail-item">
          <strong>Member Since</strong>
          <span>{{ $teacher->created_at->format('F j, Y') }}</span>
        </div>
      </div>

      <div class="mt-4">
        <a href="{{ route('teacher.profile.edit') }}" class="btn-edit">Edit Profile</a>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
