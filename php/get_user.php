<?php
session_start();

// Browser ne kaho ke aa response JSON format ma chhe
header('Content-Type: application/json');

// Check karo ke session ma user_id chhe ke nahi (User logged in chhe?)
if (isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "success",
        "name" => $_SESSION['user_name'],
        "role" => $_SESSION['role']
    ]);
} else {
    // Jo login na karyu hoy to fail moklo
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in"
    ]);
}
?>
