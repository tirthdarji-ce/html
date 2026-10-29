<?php
require_once __DIR__.'/config.php'; require_login();
$timeout = 1800;
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $timeout) { session_unset(); session_destroy(); header('Location: ../login.html'); exit; }
$_SESSION['last_activity'] = time();
?><!doctype html><html lang="en"><meta charset="utf-8"><title>Student dashboard</title><link rel="stylesheet" href="../style.css"><main class="page-wrap"><h1>Welcome, <?=e($_SESSION['name'] ?? 'Student')?>!</h1><p>You are signed in as a student.</p><a class="button" href="logout.php">Log out</a></main></html>

