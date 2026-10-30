<?php
session_start();
require 'php/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$id = $_GET['id'] ?? '';
if (!$id) { header("Location: admin_students.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $course = $_POST['course'];

    $update_stmt = $conn->prepare("UPDATE students SET full_name=?, email=?, course=? WHERE id=? AND role='student'");
    $update_stmt->bind_param("sssi", $full_name, $email, $course, $id);
    
    if ($update_stmt->execute()) {
        header("Location: admin_students.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT full_name, email, course FROM students WHERE id=? AND role='student'");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body style="font-family: Arial; padding: 50px;">
    <h2>Edit Student</h2>
    <form method="POST">
        Name: <input type="text" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required><br><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>
        Course: 
        <select name="course">
            <option value="BTech" <?php if($student['course']=='BTech') echo 'selected'; ?>>BTech</option>
            <option value="BCA" <?php if($student['course']=='BCA') echo 'selected'; ?>>BCA</option>
        </select><br><br>
        <button type="submit">Update</button>
        <a href="admin_students.php">Cancel</a>
    </form>
</body>
</html>