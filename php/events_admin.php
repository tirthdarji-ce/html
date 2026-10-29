<?php
require_once __DIR__.'/config.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $title=trim($_POST['title']??'');$cat=trim($_POST['category']??'');$date=trim($_POST['date']??'');$desc=trim($_POST['description']??'');
 if($title===''||!in_array($cat,['Technical','Cultural','Sports'],true)||!preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)){http_response_code(422);exit('Invalid event input.');}
 $s=db()->prepare('INSERT INTO events(title,category,event_date,description,created_by) VALUES(?,?,?,?,?)');$s->execute([$title,$cat,$date,$desc,$_SESSION['user_id']]);
 $log=db()->prepare('INSERT INTO audit_logs(user_id,action,details) VALUES(?,?,?)');$log->execute([$_SESSION['user_id'],'CREATE_EVENT',$title]);header('Location: events_admin.php');exit;
}
$rows=db()->query('SELECT id,title,category,event_date FROM events ORDER BY event_date')->fetchAll();
?><!doctype html><html lang="en"><meta charset="utf-8"><title>Event management</title><link rel="stylesheet" href="../style.css"><main class="page-wrap"><h1>Event Management</h1><form method="post" class="form-panel"><label>Title <input name="title" required></label><label>Category <select name="category" required><option>Technical</option><option>Cultural</option><option>Sports</option></select></label><label>Date <input type="date" name="date" required></label><label>Description <textarea name="description"></textarea></label><button class="button">Add event</button></form><h2>Events</h2><ul><?php foreach($rows as $r): ?><li><?=e($r['title'])?> — <?=e($r['category'])?> — <?=e($r['event_date'])?></li><?php endforeach; ?></ul><a href="admin_dashboard.php">Back to dashboard</a></main></html>
?>