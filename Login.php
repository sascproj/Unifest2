<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if admin
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = 'admin';
        header('Location: ../admin/dashboard.php');
        exit();
    }
    
    // Check college login
    $stmt = $pdo->prepare("SELECT * FROM colleges WHERE username = ?");
    $stmt->execute([$username]);
    $college = $stmt->fetch();
    
    if ($college && password_verify($password, $college['password'])) {
        $_SESSION['user_id'] = $college['id'];
        $_SESSION['role'] = 'college';
        $_SESSION['college_name'] = $college['name'];
        $_SESSION['username'] = $college['username'];
        header('Location: ../college/dashboard.php');
        exit();
    } else {
        header('Location: ../index.php?error=invalid_credentials');
        exit();
    }
}
?>
