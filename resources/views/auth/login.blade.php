<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechSolve Online Learning</title>
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

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            margin: 0 auto;
        }

        .login-header {
            background: var(--primary-dark);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        .login-body {
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

        .btn-login {
            background: var(--accent-green);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-login:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--primary-dark);
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

        .form-check-input:checked {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo">
                <h2>Welcome Back</h2>
                <p class="mb-0">Sign in to continue your learning journey</p>
            </div>

            <div class="login-body">
                <!-- Session Status -->
                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                        </div>
                        @if($errors->has('email'))
                            <div class="text-danger mt-2">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                        </div>
                        @if($errors->has('password'))
                            <div class="text-danger mt-2">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Remember me</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if (Route::has('password.request'))
                            <a class="login-link" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif

                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                        </button>
                    </div>

                    <div class="text-center pt-3 border-top">
                        <p>Don't have an account? <a href="{{ route('register') }}" class="login-link">Register now</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
