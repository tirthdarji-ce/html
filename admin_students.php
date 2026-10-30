<?php
session_start();
require 'php/config.php'; // Database connection

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html?status=unauthorized");
    exit();
}

$search = $_GET['search'] ?? '';
$course = $_GET['course'] ?? '';
$query = "SELECT id, full_name, email, course FROM students WHERE role = 'student'";
$params = [];
$types = "";

// Search and Filter logic
if ($search !== '') {
    $query .= " AND (full_name LIKE ? OR email LIKE ?)";
    $searchParam = "%$search%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "ss";
}
if ($course !== '') {
    $query .= " AND course = ?";
    $params[] = $course;
    $types .= "s";
}

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management | Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; }
        header { background-color: #0d6efd; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .container { background: white; margin: 40px auto; max-width: 900px; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        form { margin-bottom: 20px; display: flex; gap: 10px; }
        input, select, button { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #0d6efd; color: white; padding: 12px; text-align: left; border: 1px solid #dee2e6; }
        td { padding: 12px; border: 1px solid #dee2e6; }
        .btn-edit { background-color: #ffc107; color: black; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 5px; }
        .btn-delete { background-color: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <div><strong>StudentHub Admin</strong></div>
        <div><a href="dashboard.html">Dashboard</a> <a href="php/logout.php">Logout</a></div>
    </header>
    <div class="container">
        <h2>Student Management</h2>
        
        <!-- AHIYA CHHE SAACHI JAGYA BUTTON MUKVANI -->
        <a href="add_student.php" style="background: #198754; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-bottom: 20px; font-weight: bold;">+ Add New Student</a>
        
        <form method="GET" action="admin_students.php">
            <input type="text" name="search" placeholder="Search name..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="course">
                <option value="">All Courses</option>
                <option value="BTech" <?php if($course=='BTech') echo 'selected'; ?>>BTech</option>
                <option value="BCA" <?php if($course=='BCA') echo 'selected'; ?>>BCA</option>
            </select>
            <button type="submit" style="background: #0d6efd; color: white;">Filter</button>
            <a href="admin_students.php" style="padding: 8px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>

        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Actions</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="php/delete_student.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student record?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>