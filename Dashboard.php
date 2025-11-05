<?php
include '../includes/config.php';
include '../includes/auth.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Get statistics
$colleges_count = $pdo->query("SELECT COUNT(*) FROM colleges")->fetchColumn();
$competitions_count = $pdo->query("SELECT COUNT(*) FROM competitions")->fetchColumn();
$students_count = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | UniFest 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* PASTE YOUR ADMIN CSS HERE */
        :root {
            --primary: #2C3E50;
            --secondary: #E74C3C;
            --accent: #F39C12;
            --light: #ECF0F1;
            --dark: #2C3E50;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background-color: var(--primary);
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 1rem;
        }
        /* ... include all your admin CSS ... */
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <div class="text-center mb-4">
            <h4><i class="fas fa-user-shield me-2"></i>Admin Panel</h4>
            <small>Welcome, <?php echo $_SESSION['username']; ?></small>
        </div>
        <a href="dashboard.php" class="nav-link active"><i class="fas fa-home me-2"></i>Dashboard</a>
        <a href="manage_colleges.php" class="nav-link"><i class="fas fa-university me-2"></i>Manage Colleges</a>
        <a href="manage_competitions.php" class="nav-link"><i class="fas fa-trophy me-2"></i>Manage Competitions</a>
        <a href="../includes/logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark mb-4 rounded">
            <div class="container-fluid">
                <h4 class="text-white mb-0"><i class="fas fa-graduation-cap me-2"></i>UniFest Admin Dashboard</h4>
            </div>
        </nav>

        <!-- Dashboard Overview -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center p-3">
                    <h5>Total Colleges</h5>
                    <h2 class="text-primary fw-bold"><?php echo $colleges_count; ?></h2>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center p-3">
                    <h5>Competitions</h5>
                    <h2 class="text-success fw-bold"><?php echo $competitions_count; ?></h2>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center p-3">
                    <h5>Participants</h5>
                    <h2 class="text-warning fw-bold"><?php echo $students_count; ?></h2>
                </div>
            </div>
        </div>

        <!-- Add College Form -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h5><i class="fas fa-university me-2"></i>Add College</h5>
                    <form action="add_college.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">College Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add College</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
