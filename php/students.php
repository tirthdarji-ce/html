<?php
require_once __DIR__.'/config.php'; 
require_admin();

// Database mathi badha students no data lavvani query
$students = db()->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manage Students</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        .table th, .table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .table th { background-color: #f4f4f4; }
        .btn-add { background: #198754; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold; }
    </style>
</head>
<body>
<main class="page-wrap">
    <h1>Manage Students</h1>
    
    <!-- AHIYA CHHE TARU ADD NEW STUDENT BUTTON -->
    <a href="add_student.php" class="btn-add">+ Add New Student</a>
    
    <!-- Admin Dashboard par pacha javani link (Tari admin dashboard ni file nu je naam hoy te ahiya href ma nakhi deje, jem ke dashboard_admin.php) -->
    <a href="admin_dashboard.php" style="margin-left: 15px; color: #0d6efd; text-decoration: none; font-weight: bold;">&larr; Back to Dashboard</a>


    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $row): ?>
            <tr>
                <td><?=e($row['id'])?></td>
                <td><?=e($row['full_name'])?></td>
                <td><?=e($row['email'])?></td>
                <td><?=e($row['course'])?></td>
                <td><?=e($row['role'])?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
