<?php
require_once __DIR__.'/config.php'; require_admin();
$rows=db()->query('SELECT a.action,a.details,a.created_at,u.name FROM audit_logs a LEFT JOIN users u ON u.id=a.user_id ORDER BY a.id DESC LIMIT 100')->fetchAll();
?><!doctype html><html lang="en"><meta charset="utf-8"><title>Audit logs</title><link rel="stylesheet" href="../style.css"><main class="page-wrap"><h1>Audit Log</h1><table><thead><tr><th>Admin</th><th>Action</th><th>Details</th><th>Time</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=e($r['name']??'System')?></td><td><?=e($r['action'])?></td><td><?=e($r['details']??'')?></td><td><?=e($r['created_at'])?></td></tr><?php endforeach; ?></tbody></table><a href="admin_dashboard.php">Back to dashboard</a></main></html>
