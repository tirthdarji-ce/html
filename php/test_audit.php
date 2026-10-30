<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Config path check karje
if (file_exists('php/config.php')) {
    require 'php/config.php';
} else {
    require 'config.php';
}

$action = "Test Audit Entry";
$admin_name = "Test Admin";

$sql = "INSERT INTO audit_logs (action, user_name) VALUES ('$action', '$admin_name')";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Audit Log Entry Successful! 🎉</h1>";
    echo "Have phpMyAdmin ma jaine 'audit_logs' table check kar. Tya entry aavi gai hase!";
} else {
    echo "<h1>Error:</h1> " . $conn->error;
}

$conn->close();

?>