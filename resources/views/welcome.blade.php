<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSolve Online Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">TechSolve</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- Guest buttons -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 text-center">
    <h1>Welcome to TechSolve Online Learning!</h1>
    <p class="lead">Learn, practice, and grow your skills online. Join us today!</p>

    @guest
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg">Register</a>
    @else
        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-success btn-lg">Go to Dashboard</a>
    @endguest
</div>

<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-4">
            <h3>Teachers</h3>
            <p>Create courses, manage students, and track learning progress easily.</p>
        </div>
        <div class="col-md-4">
            <h3>Students</h3>
            <p>Access courses, practice exercises, and track your learning journey.</p>
        </div>
        <div class="col-md-4">
            <h3>Admin</h3>
            <p>Manage users, approve registrations, and monitor the platform.</p>
        </div>
    </div>
</div>

<footer class="bg-primary text-white text-center py-3 mt-5">
    &copy; {{ date('Y') }} TechSolve Online Learning. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
