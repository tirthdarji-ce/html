<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        header("Location: ../login.html?error=invalid");
        
        exit();
    }

    // Database mathi email check karo
    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Hash karelo password match karo (password_verify thi)
        if (password_verify($password, $user['password'])) {
            // Password match thai gayo! Session start karo
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
            // Login thaya pachi dashboard par moklo
            header("Location: ../dashboard.html?status=loggedin");
            exit();
        } else {
            // Khoto password
            header("Location: ../login.html?error=wrong_password");
            exit();
        }
    } else {
        // Email database ma nathi
        header("Location: ../login.html?error=not_found");
        exit();
    }
} else {
    header("Location: ../login.html");
    exit();
}
?>
