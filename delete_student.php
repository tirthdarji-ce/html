<?php
// Error display chalu rakho je thi khabar pade
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Config file include karo (path check karine)
if (file_exists('php/config.php')) {
    require 'php/config.php';
} else {
    require 'config.php';
}

// Check karo ke database connection barabar che ke nahi
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    
    // 1. Pehla Event Delete karo
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed (Delete): " . $conn->error);
    }
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    // 2. Pachhi Audit Log ma entry Pado
    $action = "Deleted Event ID: " . $event_id;
    // Session mathi full_name lo, jo na hoy to 'Admin' rakho
    $admin_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Admin';

    $log_stmt = $conn->prepare("INSERT INTO audit_logs (action, user_name) VALUES (?, ?)");
    if (!$log_stmt) {
        die("Prepare failed (Audit Log): " . $conn->error);
    }
    $log_stmt->bind_param("ss", $action, $admin_name);
    
    if ($log_stmt->execute()) {
        $log_stmt->close();
    } else {
        die("Execute failed (Audit Log): " . $log_stmt->error);
    }
}

// Redirect back to admin events page
header("Location: admin_events.php");
$conn->close();
exit();
?>