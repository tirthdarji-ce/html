<?php
require_once __DIR__.'/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../feedback.html'); exit; }
$name = trim($_POST['name'] ?? ''); $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$type = trim($_POST['type'] ?? ''); $rating = trim($_POST['rating'] ?? ''); $message = trim($_POST['message'] ?? '');
if ($name === '' || !$email || $type === '' || !in_array($rating,['Excellent','Good','Average','Poor'],true) || $message === '') { http_response_code(422); exit('Please complete all feedback fields correctly.'); }
$fp = fopen(__DIR__.'/../storage/feedback.csv','ab'); if (!$fp) { http_response_code(500); exit('Unable to save feedback.'); }
flock($fp, LOCK_EX); fputcsv($fp,[date('c'),$name,$email,$type,$rating,$message]); flock($fp, LOCK_UN); fclose($fp);
echo 'Thank you for your feedback. <a href="../index.html">Return to StudentHub</a>';
