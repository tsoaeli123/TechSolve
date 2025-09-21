<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Announcements | TechSolve</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <!-- Quill Editor -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <style>
    /* ====== Layout ====== */
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #1e2a38;
      color: #e0e6ed;
      display: flex;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background: linear-gradient(180deg, #1b2d4a 0%, #234d87 100%);
      padding: 20px;
      box-shadow: 2px 0 16px rgba(0,0,0,0.25);
      overflow-y: auto;
      z-index: 1000;
    }
    .main-content {
      flex: 1;
      margin-left: 250px;
      padding: 30px;
      animation: fadeIn 0.6s ease-in-out;
    }

    /* Sidebar Header */
    .sidebar-header {
      text-align: center;
      margin-bottom: 25px;
    }
    .sidebar-header img {
      max-width: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
      border: 3px solid #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .sidebar-header h2 {
      font-size: 18px;
      font-weight: 600;
      color: #ffffff;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar ul li {
      margin: 12px 0;
    }
    .sidebar ul li a,
    .sidebar ul li form button {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-size: 15px;
      color: #d6e0f0;
      background: transparent;
      border: none;
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .sidebar ul li a:hover,
    .sidebar ul li form button:hover {
      background: linear-gradient(90deg, #274b74, #1e3a61);
      color: #fff;
      transform: translateX(5px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .logout-btn {
      cursor: pointer;
      font-weight: 500;
    }

    /* Page Header */
    .page-header {
      background: #243447;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 25px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.4);
      border: 1px solid #2f3c4e;
    }
    .page-header h1 {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 8px;
      color: #f0f4f8;
    }
    .page-header p {
      margin: 0;
      font-size: 1rem;
      color: #a0b3c6;
    }

    /* Forms & Cards */
    .announcement-form,
    .announcement-card {
      background: #243447;
      padding: 22px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      margin-bottom: 25px;
      border: 1px solid #2f3c4e;
    }
    .announcement-card h5 { color: #f0f4f8;
       font-weight: 600; 
      }

    .announcement-meta { font-size: 0.85rem;
       color: #a0b3c6;
        margin-bottom: 12px; 
      }
    .announcement-text { font-size: 0.95rem;
       color: #d1dae6; 
      }

    /* Badges */
    .badge-class { background: #1d4ed8;
       color: #fff;
       padding: 5px 10px;
       border-radius: 6px;
       font-size: 0.8rem; 
      }
    .badge-all { background: #16a34a; }

    /* Buttons */
    .btn-post { 
      background: #2563eb;
      color: #fff; font-weight: 500;
      border: none;
      padding: 10px 18px; 
      border-radius: 6px; }
    .btn-post:hover { 
      background: #1e40af; }

    .pinned { 
      border-left: 5px solid #fbbf24; 
      background: #2d3748; }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar { width: 70px; 
        text-align: center; }
      .sidebar-header h2, .sidebar span { display: none; }
      .sidebar i { font-size: 1.3rem; }
      .main-content { margin-left: 70px; }
    }
    @media (max-width: 768px) {
      .sidebar { width: 0; 
        overflow: hidden; }
      .main-content { margin-left: 0; 
        padding: 15px; }
    }

    @keyframes fadeIn 
    { from { opacity: 0;
       transform: translateY(15px);
      } to {
         opacity: 1;
          transform: translateY(0);} 
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
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
      <div>
        <h1 class="h3 mb-1">📢 Teacher Announcements</h1>
        <p class="text-muted mb-0" style="color:white;">Manage and send updates to your students.</p>
      </div>
      <div>
        <form method="GET" action="">
          <input type="text" name="search" class="form-control" placeholder="Search announcements...">
        </form>
      </div>
    </div>

    <!-- Post Announcement Form -->
    <div class="announcement-form">
      <h4 class="mb-3">Create New Announcement</h4>
       <br>
       @if(session('success'))
       <h5 class="alert alert-success" style="background:#fff; color:green;">{{session('success')}}</h5>
       @endif

      <form class="form-control"  action="{{route('teacher.announcement')}}" method="POST" enctype="multipart/form-data">
         @csrf
        <div class="mb-3">
          <label class="form-label">Announcement Title</label>
          <input type="text" name="title" class="form-control" placeholder="e.g. Midterm Exam Update" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea type="text" row="5" class="form-control" name="message" id="message"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Audience</label>
          <select name="subject_id" class="form-control" required>
            <option value="">-- Select Subject --</option>
            <option value="0">All</option>
            @foreach($subjects as $subject)
              <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Attachments</label>
          <input type="file" name="file" class="form-control" multiple>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="pinned" value="1" id="pinned">
          <label class="form-check-label" for="pinned"> Pin this announcement</label>
        </div>

        <button type="submit" class="btn-post"><i class="bi bi-megaphone"></i> Post Announcement</button>
      </form>
    </div>

    <!-- Past Announcements -->
    <h4 class="mb-3">Recent Announcements</h4>
    @foreach($announcements as $post)
    
    <div class="announcement-card pinned">
      <h5>📌 {{$post->title}}</h5>
      <div class="announcement-meta">Posted by Mr. {{ Auth::user()->name }} · {{$post->created_at->format('l, jS, F Y')}} <span class="badge-class badge-all">
       @if($post->subject_id > 0)
       @foreach($subjects as $subject)
      @if($post->subject_id == $subject->id)
      {{$subject->name}} Students
      @endif
       @endforeach
       @else
      
      All Students
      
      @endif
      </span></div>
     
      <div class="announcement-text">{{$post->message}}.</div>
      <div class="attachments mt-2">
        <a href="#"><i class="bi bi-paperclip"></i> {{$post->filename}}</a>
      </div>
      <div class="attachments mt-2">
        <form action="{{route('teacher.destroy',$post->id )}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Announcement?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete Announcement</button>
    </form>
    </div>
    </div>
   
    @endforeach


    

    <p class="text-muted">No more announcements.</p>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  
</body>
</html>
