<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php'; 

if (isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];
    
    $admin_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Admin';
    $action = "Deleted Event ID: " . $event_id;

    // 1. Audit Log Entry (Je already chalu thai gai chhe)
    $sql_log = "INSERT INTO audit_logs (action, user_name) VALUES ('$action', '$admin_name')";
    $conn->query($sql_log);

    // 2. Event Delete Query
    $sql_delete = "DELETE FROM events WHERE id = $event_id";
    
    if ($conn->query($sql_delete) === TRUE) {
        // Jo successfully delete thai jay to events page par pacha jao
        // (Screenshot mujab tari file php folder ma 'events_admin.php' chhe)
        header("Location: events_admin.php");
        exit();
    } else {
        // Jo delete ma error aave (jem ke foreign key error), to ahiya batavse
        die("<h1>Event Delete Nathi Thai:</h1> " . $conn->error);
    }
} else {
    echo "ID malyu nathi!";
}
?>