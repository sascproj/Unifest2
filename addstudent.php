<?php
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'college') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $college_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO students (college_id, name, roll_number, department, year) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$college_id, $name, $roll_number, $department, $year]);
        
        header('Location: dashboard.php?success=student_added');
        exit();
    } catch(PDOException $e) {
        header('Location: dashboard.php?error=student_exists');
        exit();
    }
}
?>
