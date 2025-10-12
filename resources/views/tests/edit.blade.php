<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Test | TechSolve</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    /* Add your existing styles here */
    :root {
      --primary-dark: #2c3e50;
      --primary-medium: #34495e;
      --accent-blue: #3498db;
      --accent-green: #2ecc71;
    }

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

    .btn-success {
      background: var(--accent-green);
      border: none;
    }
  </style>
</head>
<body>
  <!-- Your existing sidebar and header -->

  <main class="main-content">
    <header>
      <h1>Edit Test ✏️</h1>
      <p>Update test details and timing.</p>
    </header>

    <div class="form-container">
      <form action="{{ route('tests.update', $test->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="form-label">Test Title</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $test->title) }}" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Subject</label>
          <select name="subject_id" class="form-control" required>
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
              <option value="{{ $subject->id }}" {{ $test->subject_id == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control"
                   value="{{ old('start_time', $test->start_time ? $test->start_time->format('Y-m-d\TH:i') : '') }}" required>
            <small class="text-muted">When students can start taking the test</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">End Time (Deadline)</label>
            <input type="datetime-local" name="scheduled_at" class="form-control"
                   value="{{ old('scheduled_at', $test->scheduled_at ? $test->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
            <small class="text-muted">When students must submit by</small>
          </div>
        </div>

        <button type="submit" class="btn btn-success">Update Test</button>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Add time validation
    document.addEventListener('DOMContentLoaded', function() {
      const startTimeInput = document.querySelector('input[name="start_time"]');
      const endTimeInput = document.querySelector('input[name="scheduled_at"]');

      if (startTimeInput && endTimeInput) {
        startTimeInput.addEventListener('change', function() {
          const startTime = new Date(this.value);
          const endTime = new Date(endTimeInput.value);

          if (endTimeInput.value && endTime <= startTime) {
            alert('End time must be after start time');
            endTimeInput.value = '';
          }
        });

        endTimeInput.addEventListener('change', function() {
          const startTime = new Date(startTimeInput.value);
          const endTime = new Date(this.value);

          if (startTimeInput.value && endTime <= startTime) {
            alert('End time must be after start time');
            this.value = '';
          }
        });
      }
    });
  </script>
</body>
</html>
