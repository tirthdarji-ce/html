<?php
require_once __DIR__.'/../config.php';
header('Content-Type: application/json; charset=utf-8');
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET','POST','PUT','DELETE'], true)) { http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
try {
  $pdo=db();
  if ($_SERVER['REQUEST_METHOD']==='GET') { echo json_encode($pdo->query('SELECT id,title,category,event_date AS date,description FROM events ORDER BY event_date')->fetchAll()); exit; }
  require_admin();
  $data=json_decode(file_get_contents('php://input'),true)??[];
  if ($_SERVER['REQUEST_METHOD']==='POST') {
    $s=$pdo->prepare('INSERT INTO events(title,category,event_date,description,created_by) VALUES(?,?,?,?,?)');
    $s->execute([trim($data['title']??''),$data['category']??'Technical',$data['date']??date('Y-m-d'),trim($data['description']??''),$_SESSION['user_id']]);
    http_response_code(201); echo json_encode(['id'=>(int)$pdo->lastInsertId(),'message'=>'Created']); exit;
  }
  $id=(int)($data['id']??0); if($id<1){http_response_code(422);echo json_encode(['error'=>'Valid id required']);exit;}
  if($_SERVER['REQUEST_METHOD']==='PUT'){$s=$pdo->prepare('UPDATE events SET title=?,category=?,event_date=?,description=? WHERE id=?');$s->execute([$data['title']??'',$data['category']??'Technical',$data['date']??date('Y-m-d'),$data['description']??'',$id]);echo json_encode(['message'=>'Updated']);exit;}
  $s=$pdo->prepare('DELETE FROM events WHERE id=?');$s->execute([$id]);echo json_encode(['message'=>'Deleted']);
} catch(Throwable $e){http_response_code(500);echo json_encode(['error'=>'Request failed']);}
