<?php
require 'db.php';
session_start();

$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] != 'admin') {
    die("Access denied");
}

// Handle Edit or Delete
?>
