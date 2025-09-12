<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Tests | TechSolve</title>
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

    /* Table Styles */
    .table-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
      overflow: hidden;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table thead {
      background: var(--primary-dark);
      color: white;
    }

    .table th {
      padding: 15px;
      text-align: left;
      font-weight: 600;
    }

    .table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .table tbody tr:hover {
      background-color: rgba(52, 152, 219, 0.05);
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

    .btn-sm {
      padding: 5px 10px;
      font-size: 0.875rem;
      border-radius: 4px;
      margin-right: 5px;
    }

    .btn-warning {
      background: #f39c12;
      color: white;
      border: none;
    }

    .btn-warning:hover {
      background: #e67e22;
    }

    .btn-info {
      background: #00bcd4;
      color: white;
      border: none;
    }

    .btn-info:hover {
      background: #0097a7;
    }

    .btn-secondary {
      background: var(--primary-light);
      color: white;
      border: none;
    }

    .btn-secondary:hover {
      background: var(--primary-medium);
    }

    .btn-danger {
      background: #e74c3c;
      color: white;
      border: none;
    }

    .btn-danger:hover {
      background: #c0392b;
    }

    .alert-success {
      background: rgba(46, 204, 113, 0.15);
      color: #27ae60;
      border: 1px solid #2ecc71;
      border-radius: 6px;
      padding: 12px 20px;
      margin-bottom: 20px;
    }

    .no-tests {
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

      .table-container {
        overflow-x: auto;
      }

      .table {
        min-width: 600px;
      }

      .btn-sm {
        margin-bottom: 5px;
        display: inline-block;
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
      <h1>My Tests <span class="wave">📚</span></h1>
      <p>Manage your tests and monitor student performance efficiently.</p>
    </header>

    <div class="table-container">
      <a href="{{ route('tests.create') }}" class="btn btn-primary mb-4">+ Create New Test</a>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <table class="table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Subject</th>
            <th>Deadline</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tests as $test)
            <tr>
              <td>{{ $test->title }}</td>
              <td>{{ $test->subject->name ?? 'N/A' }}</td>
              <td>{{ $test->scheduled_at ? $test->scheduled_at->format('d M Y H:i') : 'N/A' }}</td>
              <td>
                <a href="{{ route('tests.assign', $test->id) }}" class="btn btn-sm btn-warning">Assign</a>
                <a href="{{ route('tests.show', $test->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('tests.destroy', $test->id) }}" method="POST" style="display:inline;">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this test?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="no-tests">
                <i class="bi bi-journal-x" style="font-size: 2rem;"></i>
                <p>No tests created yet.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
