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
$comment_stmt = $pdo->prepare("SELECT comments.*, users.name, comments.user_id FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY comments.created_at DESC");
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

    <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['role'] === 'admin')): ?>
        <a href="edit_delete_post.php?id=<?= $post_id ?>">Edit/Delete Post</a>
    <?php endif; ?>

    <h3>Comments</h3>
    <?php foreach ($comments as $comment): ?>
        <p><strong><?= htmlspecialchars($comment['name']) ?>:</strong> <?= htmlspecialchars($comment['comment_text']) ?></p>
        
        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || $_SESSION['role'] === 'admin')): ?>
            <a href="edit_delete_comment.php?id=<?= $comment['id'] ?>&post_id=<?= $post_id ?>">Edit/Delete Comment</a>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="process_comment.php" method="POST">
            <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
            <textarea name="comment" required></textarea>
            <button type="submit">Post Comment</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Login</a> to comment.</p>
    <?php endif; ?>
    
    <a href="index.php">Back to Home</a>
</body>
</html>
