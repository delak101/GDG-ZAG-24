<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
        die("Error: Post ID is missing. <a href='index.php'>Go back</a>");
    }

    if (!isset($_POST['comment']) || empty(trim($_POST['comment']))) {
        die("Error: Comment cannot be empty. <a href='view_post.php?id=" . htmlspecialchars($_POST['post_id']) . "'>Go back</a>");
    }

    $post_id = $_POST['post_id'];
    $comment_text = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    // Insert comment
    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
    if ($stmt->execute([$post_id, $user_id, $comment_text])) {
        header("Location: view_post.php?id=" . $post_id);
        exit;
    } else {
        die("Database insertion failed.");
    }
}
?>
