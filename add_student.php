<?php
session_start();
require 'php/config.php'; 

// Khali admin j form kholi shake
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; 
    $course = $_POST['course'];

    // Database ma data nakhvani query
    $stmt = $conn->prepare("INSERT INTO students (full_name, email, password, course, role) VALUES (?, ?, ?, ?, 'student')");
    $stmt->bind_param("ssss", $full_name, $email, $password, $course);
    
    if ($stmt->execute()) {
        header("Location: admin_students.php"); // Save thaine pacho table par aavse
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 40px; }
        .container { background: white; max-width: 400px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background: #0d6efd; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%;}
        .cancel-link { display: block; text-align: center; margin-top: 15px; color: red; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>+ Add New Student</h2>
        <form method="POST">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <label>Course:</label>
            <select name="course">
                <option value="Computer Engineering">Computer Engineering</option>
                <option value="BTech">BTech</option>
                <option value="BCA">BCA</option>
                <option value="MCA">MCA</option>
            </select>
            
            <button type="submit">Save Student</button>
            <a href="admin_students.php" class="cancel-link">Cancel</a>
        </form>
    </div>
</body>
</html>
