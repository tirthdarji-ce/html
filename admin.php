<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require 'php/config.php';

// 1. Role-Based Access Control (RBAC) - Admin vagar koi na aavi sake
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html?status=unauthorized");
    exit();
}

// 2. Fetch Aggregated Statistics (Total Students & Total Events)
$studentCount = $conn->query("SELECT COUNT(*) as count FROM students WHERE role = 'student'")->fetch_assoc()['count'];
$eventCount = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];

// 3. Fetch Latest Registrations
$latestUsers = $conn->query("SELECT full_name, email, created_at FROM students WHERE role = 'student' ORDER BY created_at DESC LIMIT 5");

// 4. Fetch Audit Logs
$auditLogs = $conn->query("SELECT action, user_name, created_at FROM audit_logs ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | StudentHub</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; }
        header { background-color: #0d6efd; padding: 15px 30px; display: flex; justify-content: space-between; color: white; align-items: center; }
        header nav a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .content-section { max-width: 1000px; margin: 40px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .dashboard-cards { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .card { background: #f8f9fa; padding: 20px; border: 1px solid #ddd; border-radius: 6px; flex: 1; min-width: 200px; text-align: center; }
        .card h3 { margin-bottom: 10px; color: #0d6efd; }
        .card p { font-size: 2.5rem; font-weight: bold; margin: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0d6efd; color: white; }
    </style>
</head>
<body>
    <header>
        <div><strong>StudentHub Admin Dashboard</strong></div>
        <nav>
            <a href="admin.php" style="color: #ffc107;">Dashboard</a>
            <a href="admin_students.php">Manage Students</a>
            <a href="admin_events.php">Manage Events</a>
            <a href="logout.php" style="color: #dc3545;">Logout</a>
        </nav>
    </header>

    <main class="content-section">
        <h2>Admin Control Panel</h2>
        <p style="color: #666; margin-bottom: 25px;">System Overview and Recent Activity</p>

        <h3>System Statistics</h3>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Students</h3>
                <p><?php echo $studentCount; ?></p>
            </div>
            <div class="card">
                <h3>Total Events</h3>
                <p><?php echo $eventCount; ?></p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; flex-wrap: wrap;">
            <div>
                <h3>Latest Registrations</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($latestUsers && $latestUsers->num_rows > 0): ?>
                            <?php while($row = $latestUsers->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="2" style="text-align: center;">No registrations found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h3>Recent System Activity (Audit Log)</h3>
                <table>
                    <thead>
                        <tr style="background-color: #6c757d;">
                            <th>Action</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($auditLogs && $auditLogs->num_rows > 0): ?>
                            <?php while($row = $auditLogs->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="2" style="text-align: center;">No recent activity.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
<?php $conn->close(); ?>
