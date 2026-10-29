<?php
require_once __DIR__.'/config.php'; require_admin();
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['delete_id'])) {
  $id=(int)$_POST['delete_id']; $s=db()->prepare('DELETE FROM students WHERE id=?'); $s->execute([$id]);
  $log=db()->prepare('INSERT INTO audit_logs(user_id,action,details) VALUES(?,?,?)'); $log->execute([$_SESSION['user_id'],'DELETE_STUDENT','student_id='.$id]);
  header('Location: students.php'); exit;
}
$q=trim($_GET['q']??'');
$sql='SELECT s.id,u.name,u.email,s.course,s.year_level FROM students s JOIN users u ON u.id=s.user_id';
if($q!==''){ $sql.=' WHERE u.name LIKE :q OR u.email LIKE :q OR s.course LIKE :q'; }
$sql.=' ORDER BY s.id DESC'; $stmt=db()->prepare($sql); if($q!=='')$stmt->bindValue(':q','%'.$q.'%'); $stmt->execute(); $rows=$stmt->fetchAll();
?><!doctype html><html lang="en"><meta charset="utf-8"><title>Student management</title><link rel="stylesheet" href="../style.css"><main class="page-wrap"><h1>Student Management</h1><form method="get"><label>Search name, email, course <input name="q" value="<?=e($q)?>"></label><button class="button">Search</button></form><table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Action</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><?php foreach(['id','name','email','course','year_level'] as $k): ?><td><?=e((string)$r[$k])?></td><?php endforeach; ?><td><form method="post" onsubmit="return confirm('Delete this student?')"><input type="hidden" name="delete_id" value="<?=$r['id']?>"><button class="button" type="submit">Delete</button></form></td></tr><?php endforeach; ?></tbody></table><p><a href="admin_dashboard.php">Back to dashboard</a></p></main></html>
