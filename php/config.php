<?php
$host = "localhost";
$username = "root";
$password = ""; // Jo Mac ma MAMP vaparta hoy to ahiya "root" lakhjo
$database = "STUDENTHUB"; // Tamara phpMyAdmin screenshot mujab exact CAPITAL ma

// PHP 8+ ma 500 error aavti atkavva mate try-catch
try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>
