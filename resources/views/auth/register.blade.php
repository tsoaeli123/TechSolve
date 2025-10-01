<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TechSolve Online Learning</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #2c3e50;
            --primary-medium: #34495e;
            --accent-blue: #3498db;
            --accent-green: #2ecc71;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
            color: #333;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .register-header {
            background: var(--primary-dark);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .register-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        .register-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-register {
            background: var(--accent-green);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-register:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            border: none;
            border-radius: 8px;
            color: #27ae60;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.2);
            border: none;
            border-radius: 8px;
            color: #c0392b;
        }

        .role-fields {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .login-link {
            color: var(--accent-blue);
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-header">
                <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo">
                <h2>Create Your Account</h2>
                <p class="mb-0">Join TechSolve to enhance your learning experience</p>
            </div>

            <div class="register-body">
                @if(session('message'))
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Register As</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">-- Select Role --</option>
                                <option value="teacher" {{ old('role')=='teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="student" {{ old('role')=='student' ? 'selected' : '' }}>Student</option>
                            </select>
                        </div>
                    </div>

                    <!-- Teacher Fields -->
                    <div id="teacher-fields" class="role-fields" style="display: {{ old('role') == 'teacher' ? 'block' : 'none' }};">
                        <h5 class="mb-3"><i class="bi bi-mortarboard me-2"></i>Teacher Information</h5>
                        <div class="mb-3">
                            <label for="subject_specialization" class="form-label">Subject Specialization</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-book"></i></span>
                                <input type="text" class="form-control" id="subject_specialization" name="subject_specialization" value="{{ old('subject_specialization') }}" placeholder="e.g. Mathematics, Science, etc.">
                            </div>
                        </div>
                    </div>

                    <!-- Student Fields -->
                    <div id="student-fields" class="role-fields" style="display: {{ old('role') == 'student' ? 'block' : 'none' }};">
                        <h5 class="mb-3"><i class="bi bi-backpack me-2"></i>Student Information</h5>
                        <div class="mb-3">
                            <label for="class_grade" class="form-label">Class/Grade</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                <input type="text" class="form-control" id="class_grade" name="class_grade" value="{{ old('class_grade') }}" placeholder="e.g. Form C, Grade 10, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-register">
                            <i class="bi bi-person-plus me-2"></i> Create Account
                        </button>
                    </div>

                    <div class="text-center">
                        <p>Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleSelect.addEventListener('change', function() {
            teacherFields.style.display = this.value === 'teacher' ? 'block' : 'none';
            studentFields.style.display = this.value === 'student' ? 'block' : 'none';
        });
    </script>
</body>
</html>
