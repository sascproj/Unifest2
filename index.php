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
        :root {
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
