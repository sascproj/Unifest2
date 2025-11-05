<?php
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'college') {
    header('Location: ../index.php');
    exit();
}

$college_id = $_SESSION['user_id'];

// Get students for this college
$stmt = $pdo->prepare("SELECT * FROM students WHERE college_id = ? ORDER BY name");
$stmt->execute([$college_id]);
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - UniFest 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Your college CSS styles */
    </style>
</head>
<body>
    <!-- Same navbar and sidebar as dashboard.php -->

    <div class="col-md-9 col-lg-10 p-4">
        <h2 class="mb-4 fw-bold text-dark">Manage Students</h2>

        <!-- Students Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users me-2"></i>Student List
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Roll Number</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                            <td><?php echo $student['year']; ?> Year</td>
                            <td>
                                <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
