<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSolve Online Learning - Empowering Lesotho Students</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #2c3e50;
            --primary-medium: #34495e;
            --primary-light: #4a6572;
            --accent-blue: #3498db;
            --accent-green: #2ecc71;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #343a40;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
            line-height: 1.6;
        }

        .navbar {
            background: rgba(44, 62, 80, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .hero-section {
            padding: 7rem 0 5rem;
        }

        .welcome-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3.5rem;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .lead {
            font-size: 1.25rem;
            color: #dbeafe;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-success {
            background: var(--accent-green);
            border-color: var(--accent-green);
        }

        .btn-success:hover {
            background: #27ae60;
            border-color: #27ae60;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--accent-blue);
        }

        .feature-card h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }

        .feature-card p {
            color: #dbeafe;
        }

        footer {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .value-card {
            text-align: center;
            padding: 1.5rem;
        }

        .value-icon {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 1rem;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            color: #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .testimonial-author {
            font-weight: 600;
            color: #fff;
        }

        .testimonial-role {
            font-size: 0.9rem;
            color: #dbeafe;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
            color: #fff;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 2rem;
        }

        .contact-icon {
            font-size: 1.5rem;
            color: var(--accent-blue);
            margin-right: 1rem;
        }

        /* Lesotho flag colors */
        .lesotho-flag {
            height: 20px;
            width: 30px;
            background: linear-gradient(to bottom, #ffffff 0%, #ffffff 33%, #009543 33%, #009543 66%, #00209f 66%, #00209f 100%);
            display: inline-block;
            margin-right: 10px;
            border-radius: 2px;
            vertical-align: middle;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .welcome-box {
                padding: 2rem;
            }

            h1 {
                font-size: 2.2rem;
            }

            .lead {
                font-size: 1.1rem;
            }

            .hero-section {
                padding: 5rem 0 3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.jpg') }}" alt="TechSolve Logo" width="50" height="50" class="d-inline-block align-text-top me-3 rounded-circle">
                Online Exam Center <span class="lesotho-flag"></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">



                    <li class="nav-item">
                        <a class="nav-link" href="#">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @guest
                    <li class="nav-item ms-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    </li>
                    @else
                    <li class="nav-item ms-2">
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-success btn-sm">Dashboard</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="welcome-box text-center">
                        <h1>Empowering Lesotho Students Through Technology</h1>
                        <p class="lead">Monthly testing, performance tracking, and personalized learning to help students achieve academic excellence</p>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-5">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary me-md-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-success">
                                    <i class="bi bi-person-plus me-2"></i>Join Now
                                </a>
                            @else
                                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-success">
                                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                                </a>
                            @endguest
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-4 col-6 text-center">
                                <div class="value-card">
                                    <i class="bi bi-people-fill value-icon"></i>
                                    <h4>Open to All</h4>
                                    <p class="mb-0">Students from all schools in Lesotho are welcome</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 text-center">
                                <div class="value-card">
                                    <i class="bi bi-graph-up-arrow value-icon"></i>
                                    <h4>Proven Results</h4>
                                    <p class="mb-0">Students consistently improve their performance</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 text-center mx-auto">
                                <div class="value-card">
                                    <i class="bi bi-award value-icon"></i>
                                    <h4>Quality Content</h4>
                                    <p class="mb-0">Curriculum-aligned materials for Lesotho students</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-5 bg-dark bg-opacity-50">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Our Mission: Elevating Education in Lesotho</h2>
                    <p class="mb-4">The Online Exam Center was created to address the academic performance challenges facing students in Lesotho. Through An Innovative monthly testing system, it provides students with the opportunity to:</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Regular assessment to identify knowledge gaps</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Detailed performance analytics for students and teachers</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Personalized learning recommendations</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Curriculum-aligned content for Lesotho schools</li>
                    </ul>
                    <p class="mt-4 fst-italic">"If not you then who? Join us in transforming education in Lesotho."</p>
                </div>
                <div class="col-lg-6">
                    <div class="feature-card p-4">
                        <h3 class="text-center mb-4">Monthly Testing Process</h3>
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">1</span>
                            </div>
                            <div>
                                <h5 class="mb-0">Register for Monthly Tests</h5>
                                <p class="mb-0 text-muted">Sign up for our scheduled monthly assessments</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">2</span>
                            </div>
                            <div>
                                <h5 class="mb-0">Take the Assessment</h5>
                                <p class="mb-0 text-muted">Complete the test online at your convenience</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">3</span>
                            </div>
                            <div>
                                <h5 class="mb-0">Receive Detailed Analytics</h5>
                                <p class="mb-0 text-muted">Get personalized feedback on your performance</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <span class="text-white fw-bold">4</span>
                            </div>
                            <div>
                                <h5 class="mb-0">Improve Your Results</h5>
                                <p class="mb-0 text-muted">Use our resources to strengthen weak areas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container py-5">
            <h2 class="section-title">How TechSolve Works For You</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h3>For Teachers & Schools</h3>
                        <p>Monitor class performance, identify struggling students, and access curriculum-aligned resources designed for Lesotho education system.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h3>For Students</h3>
                        <p>Track your academic progress, identify areas for improvement, and access practice materials to excel in your studies.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3>For Parents</h3>
                        <p>Stay informed about your child's academic performance and receive recommendations to support their learning journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container py-5">
            <h2 class="section-title">Contact TechSolve</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-info">
                        <h3 class="text-center mb-4">Get in Touch With Us</h3>
                        <p class="text-center mb-4">Reach out to learn more about how TechSolve can help improve academic performance. All students, teachers, and schools in Lesotho are welcome to join.</p>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-telephone-fill contact-icon"></i>
                            <div>
                                <h5 class="mb-0">Call/WhatsApp</h5>
                                <p class="mb-0">+266 56937917, +266 62018249, +266 5636 6887, +266 5974 0574</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-facebook contact-icon"></i>
                            <div>
                                <h5 class="mb-0">Facebook</h5>
                                <p class="mb-0">TechSolve innovations</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-youtube contact-icon"></i>
                            <div>
                                <h5 class="mb-0">YouTube</h5>
                                <p class="mb-0">TechSolve</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-linkedin contact-icon"></i>
                            <div>
                                <h5 class="mb-0">LinkedIn</h5>
                                <p class="mb-0">TechSolve</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="fst-italic">"If not you then who? Join us in transforming education in Lesotho."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} TechSolve Online Learning. All rights reserved.</p>
            <div class="mt-2">
                <span class="lesotho-flag"></span> Proudly serving Lesotho's education needs
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
