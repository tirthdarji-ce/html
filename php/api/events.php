<?php
require_once __DIR__.'/config.php';
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
try {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(db()->query('SELECT id,title,category,event_date AS date,description FROM events ORDER BY event_date')->fetchAll());
    exit;
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_admin();
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
    $title = trim($data['title'] ?? ''); $category = trim($data['category'] ?? ''); $date = trim($data['date'] ?? ''); $description = trim($data['description'] ?? '');
    if ($title === '' || !in_array($category,['Technical','Cultural','Sports'],true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) { http_response_code(422); echo json_encode(['error'=>'Invalid event data']); exit; }
    $s = db()->prepare('INSERT INTO events(title,category,event_date,description,created_by) VALUES(?,?,?,?,?)');
    $s->execute([$title,$category,$date,$description,$_SESSION['user_id']]);
    http_response_code(201); echo json_encode(['id'=>(int)db()->lastInsertId(),'message'=>'Event created']); exit;
  }
  http_response_code(405); echo json_encode(['error'=>'Method not allowed']);
} catch (Throwable $e) { http_response_code(500); echo json_encode(['error'=>'Server error']); }
