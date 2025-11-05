<?php
include 'includes/config.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: college/dashboard.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Festival Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* PASTE ALL YOUR EXISTING CSS FROM main.html HERE */
        
            --primary: #2C3E50;
            --secondary: #E74C3C;
            --accent: #F39C12;
            --success: #27AE60;
            --warning: #F1C40F;
            --info: #3498DB;
            --light: #ECF0F1;
            --dark: #2C3E50;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
        }

        /* ===== NAVIGATION ===== */
        .navbar {
            background: linear-gradient(135deg, var(--primary), #1a2530);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            border-top: 4px solid var(--primary);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0.5rem 0;
        }

        .stat-label {
            color: var(--dark);
            font-weight: 500;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success);
            border: none;
        }

        .btn-warning {
            background-color: var(--warning);
            border: none;
            color: var(--dark);
        }

        .btn-danger {
            background-color: var(--secondary);
            border: none;
        }

        /* ===== TABLES ===== */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .table th {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tr:nth-child(even) {
            background-color: rgba(236, 240, 241, 0.5);
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-primary {
            background-color: var(--primary);
        }

        .badge-success {
            background-color: var(--success);
        }

        .badge-warning {
            background-color: var(--warning);
            color: var(--dark);
        }

        .badge-danger {
            background-color: var(--secondary);
        }

        /* ===== SCHEDULE ===== */
        .schedule-item {
            padding: 1rem 1.5rem;
            border-left: 4px solid var(--primary);
            margin-bottom: 1rem;
            background: white;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .schedule-time {
            font-weight: 600;
            color: var(--primary);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: linear-gradient(135deg, var(--primary), #1a2530);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 3rem;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        /* ===== LOGIN FORM ===== */
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* ===== DASHBOARD ===== */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .sidebar {
            background: var(--primary);
            color: white;
            min-height: calc(100vh - 76px);
            padding: 0;
        }

        .sidebar-sticky {
            position: sticky;
            top: 76px;
            padding-top: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1.5rem;
            border-radius: 0;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p {
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
    </style
        /* ... include all your CSS styles ... */
    </style>
</head>
<body>
    <!-- Navigation - Keep your existing navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>UniFest 2026
            </a>
            <!-- ... rest of your navigation ... -->
        </div>
    </nav>

    <!-- Hero Section - Keep your existing hero section -->
    <section class="hero-section">
        <div class="container">
            <h1>University Festival 2026</h1>
            <p>Join us for the most exciting inter-college competition featuring cultural events, technical competitions, and sports tournaments.</p>
            <!-- ... rest of your hero section ... -->
        </div>
    </section>

    <!-- Rest of your main.html content -->

    <!-- UPDATE THE LOGIN FORM -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sign-in-alt me-2"></i>College Login
        </div>
        <div class="card-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Invalid username or password!</div>
            <?php endif; ?>
            
            <form action="includes/login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="text-center mt-3">
                    <a href="admin/login.php" class="text-muted small">Admin Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Keep your footer -->
    <footer class="footer">
        <!-- ... your existing footer ... -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
