<?php
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO colleges (name, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $username, $password]);
        
        header('Location: dashboard.php?success=college_added');
        exit();
    } catch(PDOException $e) {
        header('Location: dashboard.php?error=college_exists');
        exit();
    }
}
?>
