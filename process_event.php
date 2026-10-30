<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require 'php/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html?status=unauthorized");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $category = trim($_POST["category"]);
    $event_date = $_POST["event_date"];
    $description = trim($_POST["description"]);
    
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['poster']['tmp_name'];
        $fileName = $_FILES['poster']['name'];
        $fileSize = $_FILES['poster']['size'];
        
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedExts = ['jpg', 'jpeg', 'png'];
        $maxSize = 2 * 1024 * 1024; // 2MB limit
        
        if (!in_array($fileExtension, $allowedExts)) {
            header("Location: admin_events.php?status=error&msg=Invalid file type. Only JPG and PNG allowed.");
            exit();
        }
        if ($fileSize > $maxSize) {
            header("Location: admin_events.php?status=error&msg=File exceeds 2MB limit.");
            exit();
        }
        
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        // Absolute path use karyo chhe jethi moving file ma error na aave
        $uploadFileDir = __DIR__ . '/posters/';
        
        // Jo posters folder na hoy to code aape-aape banavi dese
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }
        
        $dest_path = $uploadFileDir . $newFileName;
        
        // Ahiya move_uploaded_file sathe exact system error check karishu
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $stmt = $conn->prepare("INSERT INTO events (title, category, event_date, description, poster_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $category, $event_date, $description, $newFileName);
            if ($stmt->execute()) {
                header("Location: admin_events.php?status=added");
            } else {
                header("Location: admin_events.php?status=error&msg=Database insertion failed.");
            }
            $stmt->close();
        } else {
            // Aa exact PHP error print karse ke kem fail thayu
            $php_errormsg = error_get_last();
            echo "<h3>Upload Failed Debug:</h3>";
            echo "Upload Error Code: " . $_FILES['poster']['error'] . "<br>";
            echo "Is Writable: " . (is_writable($uploadFileDir) ? "Yes" : "No") . "<br>";
            echo "System Error: " . ($php_errormsg['message'] ?? 'Unknown error') . "<br>";
            exit();
        }
    }
}
$conn->close();
?>