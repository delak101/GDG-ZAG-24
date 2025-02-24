<?php
require 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$comment_id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);

echo "Comment deleted!";
?>
