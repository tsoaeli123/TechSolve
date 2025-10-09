{{-- resources/views/student/report.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Performance Report | TechSolve</title>
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

    /* Report Card Styles */
    .report-card {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
      border: none;
    }

    .stat-card {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      text-align: center;
      transition: transform 0.3s;
      height: 100%;
      border: none;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .stat-label {
      color: var(--primary-light);
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .performance-badge {
      font-size: 0.8rem;
      padding: 6px 12px;
      border-radius: 20px;
    }

    .subject-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
      transition: transform 0.3s;
    }

    .subject-card:hover {
      transform: translateY(-3px);
    }

    .subject-header {
      border-radius: 12px 12px 0 0 !important;
      padding: 20px;
    }

    .table th {
      background-color: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
      font-weight: 600;
    }

    .progress {
      height: 8px;
      margin-top: 5px;
    }

    /* Print Styles */
    @media print {
      .sidebar, .btn, .alert.alert-warning {
        display: none !important;
      }
      .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
      }
      .report-card, .stat-card, .subject-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
      }
      .badge {
        border: 1px solid #000 !important;
      }
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

      .stat-card {
        margin-bottom: 15px;
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
      <li><a href="{{ route('student.report') }}" class="active"><i class="bi bi-graph-up"></i> <span>Performance Report</span></a></li>
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
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h1>Performance Report <span class="wave">📊</span></h1>
          <p>Comprehensive analysis of your academic performance across all subjects</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-primary">
          <i class="bi bi-download"></i> Download Report
        </button>
      </div>
    </header>

    <!-- Student Information -->
    <div class="report-card">
      <div class="row">
        <div class="col-md-6">
          <h5 class="text-primary mb-3"><i class="bi bi-person-circle me-2"></i>Student Information</h5>
          <p class="mb-2"><strong>Name:</strong> {{ Auth::user()->name }}</p>
          <p class="mb-2"><strong>Class:</strong> {{ Auth::user()->class_grade ?? 'N/A' }}</p>
          <p class="mb-0"><strong>Report Generated:</strong> {{ now()->format('d M Y H:i') }}</p>
        </div>
        <div class="col-md-6 text-md-end">
          <h5 class="text-primary mb-3"><i class="bi bi-journal-text me-2"></i>Academic Summary</h5>
          <p class="mb-2"><strong>Academic Year:</strong> {{ now()->year }}/{{ now()->addYear()->format('y') }}</p>
          <p class="mb-2"><strong>Total Tests Completed:</strong> {{ $totalTests ?? 0 }}</p>
          <p class="mb-0"><strong>Report ID:</strong> STU-{{ Auth::id() }}-{{ now()->format('Ymd') }}</p>
        </div>
      </div>
    </div>

    @if(($totalTests ?? 0) > 0)
    <!-- Overall Performance Stats -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="stat-card border-{{ $performanceColor ?? 'secondary' }}">
          <div class="stat-number text-{{ $performanceColor ?? 'secondary' }}">
            {{ number_format($overallPercentage ?? 0, 1) }}%
          </div>
          <div class="stat-label">Overall Performance</div>
          <span class="badge performance-badge bg-{{ $performanceColor ?? 'secondary' }} mt-2">
            {{ $performanceLevel ?? 'No Data' }}
          </span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card border-primary">
          <div class="stat-number text-primary">
            {{ $totalTests ?? 0 }}
          </div>
          <div class="stat-label">Tests Completed</div>
          <small class="text-muted">{{ count($subjectPerformance ?? []) }} subjects</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card border-info">
          <div class="stat-number text-info">
            {{ $totalMarks ?? 0 }}/{{ $totalPossibleMarks ?? 0 }}
          </div>
          <div class="stat-label">Total Marks</div>
          <small class="text-muted">{{ number_format($overallPercentage ?? 0, 1) }}% Success Rate</small>
        </div>
      </div>
    </div>

    <!-- Subject-wise Performance -->
    <div class="report-card">
      <h4 class="mb-4 text-primary">
        <i class="bi bi-journal-text me-2"></i>
        Subject-wise Performance Details
      </h4>

      @foreach($subjectPerformance ?? [] as $subjectName => $subjectData)
      <div class="card subject-card mb-4">
        <div class="card-header subject-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            {{ $subjectName }}
            <span class="badge bg-light text-dark ms-2">
              {{ $subjectData['tests_count'] }} test(s)
            </span>
          </h5>
          <span class="badge bg-{{ $subjectData['performance_color'] }} performance-badge">
            {{ $subjectData['performance_level'] }}
          </span>
        </div>
        <div class="card-body">
          <!-- Subject Summary -->
          <div class="row mb-4">
            <div class="col-md-8">
              <div class="d-flex align-items-center">
                <strong class="me-3">Subject Performance:</strong>
                <div class="flex-grow-1">
                  <div class="progress">
                    <div class="progress-bar bg-{{ $subjectData['performance_color'] }}"
                         style="width: {{ $subjectData['percentage'] }}%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-md-end">
              <strong>Overall Score:</strong>
              {{ $subjectData['total_marks'] }}/{{ $subjectData['total_possible_marks'] }}
              ({{ number_format($subjectData['percentage'], 1) }}%)
            </div>
          </div>

          <!-- Individual Test Results -->
          <h6 class="border-bottom pb-2 mb-3">
            <i class="bi bi-list-check me-2"></i>Individual Test Results:
          </h6>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>Test Name</th>
                  <th>Date Submitted</th>
                  <th>Marks Obtained</th>
                  <th>Percentage</th>
                  <th>Performance</th>
                </tr>
              </thead>
              <tbody>
                @foreach($subjectData['tests'] as $test)
                <tr>
                  <td>
                    <strong>{{ $test['test_title'] }}</strong>
                  </td>
                  <td>
                    @php
                      $submittedDate = $test['submitted_at'];
                      if ($submittedDate instanceof \Carbon\Carbon) {
                          $formattedDate = $submittedDate->format('d M Y');
                      } elseif (is_string($submittedDate)) {
                          try {
                              $formattedDate = \Carbon\Carbon::parse($submittedDate)->format('d M Y');
                          } catch (\Exception $e) {
                              $formattedDate = 'Date not available';
                          }
                      } else {
                          $formattedDate = 'Date not available';
                      }
                    @endphp
                    {{ $formattedDate }}
                  </td>
                  <td>
                    {{ $test['marks'] }}/{{ $test['possible_marks'] }}
                  </td>
                  <td>
                    {{ number_format($test['percentage'], 1) }}%
                  </td>
                  <td>
                    <span class="badge bg-{{ $test['performance_color'] }} performance-badge">
                      {{ $test['performance_level'] }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot class="table-secondary">
                <tr>
                  <td colspan="2"><strong>Subject Average</strong></td>
                  <td>
                    <strong>{{ $subjectData['total_marks'] }}/{{ $subjectData['total_possible_marks'] }}</strong>
                  </td>
                  <td>
                    <strong>{{ number_format($subjectData['percentage'], 1) }}%</strong>
                  </td>
                  <td>
                    <span class="badge bg-{{ $subjectData['performance_color'] }} performance-badge">
                      {{ $subjectData['performance_level'] }}
                    </span>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      @endforeach

      <!-- Performance Legend -->
      <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
          <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Performance Rating Legend</h6>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-md-2 mb-2">
              <span class="badge bg-success performance-badge">Excellent (90-100%)</span>
            </div>
            <div class="col-md-2 mb-2">
              <span class="badge bg-info performance-badge">Very Good (80-89%)</span>
            </div>
            <div class="col-md-2 mb-2">
              <span class="badge bg-primary performance-badge">Good (70-79%)</span>
            </div>
            <div class="col-md-2 mb-2">
              <span class="badge bg-warning performance-badge">Satisfactory (60-69%)</span>
            </div>
            <div class="col-md-2 mb-2">
              <span class="badge bg-secondary performance-badge">Average (50-59%)</span>
            </div>
            <div class="col-md-2 mb-2">
              <span class="badge bg-danger performance-badge">Needs Improvement (<50%)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    @else
    <!-- No Tests Available -->
    <div class="report-card text-center py-5">
      <div class="mb-4">
        <i class="bi bi-graph-up" style="font-size: 4rem; color: #6c757d;"></i>
      </div>
      <h4 class="text-muted mb-3">No Performance Data Available</h4>
      <p class="text-muted mb-4">You haven't completed any tests yet, or your tests are still being graded.</p>
      <a href="{{ route('student.dashboard') }}" class="btn btn-primary">
        <i class="bi bi-house me-2"></i>Go to Dashboard
      </a>
    </div>
    @endif

    <!-- Footer -->
    <div class="text-center mt-4 text-muted">
      <small>Report generated on {{ now()->format('F j, Y \\a\\t g:i A') }} • TechSolve Learning Platform</small>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
