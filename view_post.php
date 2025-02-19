<?php
require 'db.php';
session_start();

if (!isset($_GET['id'])) {
    die("Post not found.");
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}

// Fetch comments
$comment_stmt = $pdo->prepare("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY comments.created_at DESC");
$comment_stmt->execute([$post_id]);
$comments = $comment_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
</head>
<body>
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p><strong>By:</strong> <?= htmlspecialchars($post['name']) ?></p>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <h3>Comments</h3>
    <?php foreach ($comments as $comment): ?>
        <p><strong><?= htmlspecialchars($comment['name']) ?>:</strong> <?= htmlspecialchars($comment['comment_text']) ?></p>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="delete_comment.php?id=<?= $comment['id'] ?>">Delete</a>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <h4><a href="add_comment.php?post_id=<?= htmlspecialchars($post_id) ?>">Add a Comment</a></h4>
    <?php else: ?>
        <p><a href="login.php">Login</a> to comment.</p>
    <?php endif; ?>
    
    <a href="index.php">Back to Home</a>
</body>
</html>
