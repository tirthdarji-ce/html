<?php
// Aa 3 line PHP ne force karse ke e exact error batabe (500 ni jagya e)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Database mathi data lavvani query
    $query = "SELECT id, full_name, password, role FROM students WHERE email = ?";
    $stmt = $conn->prepare($query);

    // JO QUERY FAIL THAY (Table ke column nu naam khotu hoy to) ahiya exact error batavse
    if (!$stmt) {
        die("<h3 style='color:red;'>SQL ERROR: " . $conn->error . "</h3><p>Check karo ke tamara database ma 'students' table ane 'full_name', 'role' columns chhe ke nahi.</p>");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_id, $db_full_name, $db_password, $db_role);

    if ($stmt->fetch()) {
        if ($password === $db_password || password_verify($password, $db_password)) {
            $_SESSION['user_id'] = $db_id;
            $_SESSION['user_name'] = $db_full_name;
            $_SESSION['role'] = $db_role;

            if ($db_role === 'admin') {
                header("Location: ../admin_students.php");
            } else {
                header("Location: ../dashboard.html?status=loggedin");
            }
            exit();
        } else {
            header("Location: ../login.html?error=wrongpassword");
            exit();
        }
    } else {
        header("Location: ../login.html?error=notfound");
        exit();
    }
    $stmt->close();
} else {
    echo "Form Submit nathi thayu.";
}
?>