<?php
require_once __DIR__.'/config.php'; 
require_admin();

$counts = [];
foreach (['users','students','events','registrations'] as $table) { 
    $counts[$table] = (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn(); 
}
$latest = db()->query('SELECT u.name,u.email,u.created_at FROM users u ORDER BY u.created_at DESC LIMIT 5')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<main class="page-wrap">
    <h1>Admin dashboard</h1>
    <p>Signed in as <?=e($_SESSION['name'] ?? 'Admin')?>.</p>
    
    <!-- AHIYA NAVU BUTTON MUKYU CHHE -->
    <a href="add_student.php" style="background: #198754; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-bottom: 20px; font-weight: bold;">+ Add New Student</a>

    <section class="stats-grid">
        <?php foreach($counts as $label=>$count): ?>
        <article class="stat-card">
            <span><?=e(ucfirst($label))?></span><strong><?=$count?></strong>
        </article>
        <?php endforeach; ?>
    </section>
    
    <h2>Latest registrations</h2>
    <ul>
        <?php foreach($latest as $row): ?>
        <li><?=e($row['name'])?> — <?=e($row['email'])?> (<?=e($row['created_at'])?>)</li>
        <?php endforeach; ?>
    </ul>
    
    <p><a href="students.php">Manage students</a> · <a href="events_admin.php">Manage events</a> · <a href="audit_logs.php">Audit log</a> · <a href="logout.php">Log out</a></p>
</main>
</body>
</html>
<?php
require_once __DIR__.'/config.php'; 
require_admin();

$counts = [];
foreach (['users','students','events','registrations'] as $table) { 
    $counts[$table] = (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn(); 
}
$latest = db()->query('SELECT u.name,u.email,u.created_at FROM users u ORDER BY u.created_at DESC LIMIT 5')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<main class="page-wrap">
    <h1>Admin dashboard</h1>
    <p>Signed in as <?=e($_SESSION['name'] ?? 'Admin')?>.</p>
    
    <!-- AHIYA NAVU BUTTON MUKYU CHHE -->
    <a href="add_student.php" style="background: #198754; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-bottom: 20px; font-weight: bold;">+ Add New Student</a>

    <section class="stats-grid">
        <?php foreach($counts as $label=>$count): ?>
        <article class="stat-card">
            <span><?=e(ucfirst($label))?></span><strong><?=$count?></strong>
        </article>
        <?php endforeach; ?>
    </section>
    
    <h2>Latest registrations</h2>
    <ul>
        <?php foreach($latest as $row): ?>
        <li><?=e($row['name'])?> — <?=e($row['email'])?> (<?=e($row['created_at'])?>)</li>
        <?php endforeach; ?>
    </ul>
    
    <p><a href="students.php">Manage students</a> · <a href="events_admin.php">Manage events</a> · <a href="audit_logs.php">Audit log</a> · <a href="logout.php">Log out</a></p>
</main>
</body>
</html>
