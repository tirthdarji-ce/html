<?php
// Database connection file ne include karo
require 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Read values from POST array. Notice "fullName" now matches the HTML name attribute.
    $fullName = filter_var(trim($_POST["fullName"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mobile = filter_var(trim($_POST["mobile"]), FILTER_SANITIZE_STRING);
    $course = filter_var(trim($_POST["course"]), FILTER_SANITIZE_STRING);
    
    // Ensure year is cast to integer to match database schema requirements
    $year = isset($_POST["year"]) ? (int)$_POST["year"] : 0; 
    
    $gender = filter_var(trim($_POST["gender"] ?? ''), FILTER_SANITIZE_STRING);
    $password = $_POST["password"];

    // Validation
    if (empty($fullName) || empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $year === 0) {
        header("Location: ../register.html?status=error&msg=invalid_input");
        exit();
    }

    // Duplicate email check
    $stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        header("Location: ../register.html?status=error&msg=duplicate_email");
        exit();
    }
    
    $stmt->close();

    // Password Hashing ane Database Insert
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Using parameter type "i" for enroll_year since it is an integer in the database
    $insertStmt = $conn->prepare("INSERT INTO students (full_name, email, mobile, course, enroll_year, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("ssssiss", $fullName, $email, $mobile, $course, $year, $gender, $hashedPassword);
    
    if ($insertStmt->execute()) {
        $insertStmt->close();
        header("Location: ../register.html?status=success");
        exit();
    } else {
        $insertStmt->close();
        header("Location: ../register.html?status=error&msg=db_error");
        exit();
    }
} else {
    header("Location: ../register.html");
    exit();
}
?>