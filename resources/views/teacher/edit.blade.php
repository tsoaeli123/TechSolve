<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Teacher Profile | TechSolve Online Learning</title>
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

    /* Form Styles */
    .form-container {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
    }

    .form-label {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 8px;
    }

    .form-control {
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 10px 15px;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .btn-primary {
      background: var(--accent-green);
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background: #27ae60;
      transform: translateY(-2px);
    }

    .btn-danger {
      background: #e74c3c;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-danger:hover {
      background: #c0392b;
      transform: translateY(-2px);
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: none;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .text-danger {
      color: #e74c3c !important;
    }

    .delete-section {
      border-top: 1px solid #eee;
      padding-top: 25px;
      margin-top: 25px;
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
      <h1>Edit Teacher Profile <span class="wave">👤</span></h1>
      <p>Update your personal information and account settings.</p>
    </header>

    <div class="form-container">
      <!-- Success message -->
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('teacher.profile.update') }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
          <label for="name" class="form-label">Name</label>
          <input id="name" type="text" name="name" value="{{ old('name', $teacher->name) }}" required autofocus
                class="form-control @error('name') is-invalid @enderror">
          @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="form-label">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email', $teacher->email) }}" required
                class="form-control @error('email') is-invalid @enderror">
          @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Subject Specialization -->
        <div class="mb-4">
          <label for="subject_specialization" class="form-label">Subject Specialization</label>
          <input id="subject_specialization" type="text" name="subject_specialization"
                value="{{ old('subject_specialization', $teacher->subject_specialization) }}"
                class="form-control @error('subject_specialization') is-invalid @enderror">
          @error('subject_specialization')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="form-label">New Password (leave blank to keep current)</label>
          <input id="password" type="password" name="password"
                class="form-control @error('password') is-invalid @enderror">
          @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <label for="password_confirmation" class="form-label">Confirm New Password</label>
          <input id="password_confirmation" type="password" name="password_confirmation"
                class="form-control">
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            Update Profile
          </button>
        </div>
      </form>

      <!-- Delete Account -->
      <div class="delete-section">
        <form method="POST" action="{{ route('teacher.profile.destroy') }}">
          @csrf
          @method('DELETE')

          <h2 class="h5 text-danger mb-3">Delete Account</h2>
          <p class="text-muted mb-3">Enter your password to confirm deletion.</p>

          <div class="mb-3">
            <input type="password" name="password" placeholder="Your password"
                  class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-danger">
            Delete Account
          </button>
        </form>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
