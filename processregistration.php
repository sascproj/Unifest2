<?php
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'college') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $competition_id = $_POST['competition_id'];
    $college_id = $_SESSION['user_id'];
    
    // Verify student belongs to college
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ? AND college_id = ?");
    $stmt->execute([$student_id, $college_id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        header('Location: register_competitions.php?error=invalid_student');
        exit();
    }
    
    // Check if already registered
    $stmt = $pdo->prepare("SELECT * FROM registrations WHERE student_id = ? AND competition_id = ?");
    $stmt->execute([$student_id, $competition_id]);
    
    if ($stmt->fetch()) {
        header('Location: register_competitions.php?error=already_registered');
        exit();
    }
    
    // Register student
    $stmt = $pdo->prepare("INSERT INTO registrations (student_id, competition_id) VALUES (?, ?)");
    $stmt->execute([$student_id, $competition_id]);
    
    header('Location: register_competitions.php?success=registered');
    exit();
}
?>
