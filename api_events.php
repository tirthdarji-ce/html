<?php
header('Content-Type: application/json');
require 'php/config.php';

// Database mathi badha events fetch karva
$query = "SELECT id, title, category, event_date, description, poster_image FROM events ORDER BY event_date DESC";
$result = $conn->query($query);

$events = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Data ne JSON format ma output aapvu
echo json_encode([
    "status" => "success",
    "data" => $events
]);

$conn->close();
?>
