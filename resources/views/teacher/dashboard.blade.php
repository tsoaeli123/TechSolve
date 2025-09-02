<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard | Online Monthly Testing System</title>
  <link rel="stylesheet" href="{{ asset('css/teacher_dashboard.css') }}">
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>Teacher Panel</h2>
    <ul>
      <li><a href="#">📚 Create Test</a></li>
      <li><a href="#">📝 Manage Tests</a></li>
      <li><a href="#">⏰ Schedule Test</a></li>
      <li><a href="#">🧮 Auto-Grade</a></li>
      <li><a href="#">✍️ Grade Answers</a></li>
      <li><a href="#">📊 Publish Results</a></li>
      <li><a href="#">📈 Student Performance</a></li>
      <li><a href="{{ route('logout') }}">🚪 Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <header>
      <h1>Hello, {{ Auth::user()->name }} 👋</h1>
      <p>Manage your tests and monitor student performance efficiently.</p>
    </header>

    <section class="cards">
      <div class="card">
        <h3>Create & Assign Test</h3>
        <p>Build tests with objective & subjective questions for your students.</p>
        <button>Create Test</button>
      </div>

      <div class="card">
        <h3>Schedule Deadlines</h3>
        <p>Set durations and deadlines for upcoming tests effortlessly.</p>
        <button>Schedule</button>
      </div>

      <div class="card">
        <h3>Grade & Publish Results</h3>
        <p>Auto-grade objective questions and manually grade subjective ones.</p>
        <button>Manage Results</button>
      </div>

      <div class="card">
        <h3>Student Performance</h3>
        <p>Track scores and progress of your students at a glance.</p>
        <button>View Reports</button>
      </div>
    </section>
  </main>
</body>
</html>
