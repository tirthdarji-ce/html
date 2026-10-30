<?php
session_start();
require 'config.php'; // Ahiya khali config.php aavse karan ke aapne php folder ma chhiye

// Admin verification[cite: 1]
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ? AND role = 'student'");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back[cite: 1]
header("Location: ../admin_students.php");
$conn->close();
exit();
?>
