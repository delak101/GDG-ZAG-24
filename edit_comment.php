<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$comment_id = $_GET['id'];

// Fetch comment
$stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
    die("Comment not found.");
}

// Ensure user owns comment
if ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['role'] !== 'admin') {
    die("Unauthorized action.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['comment']) || empty(trim($_POST['comment']))) {
        die("Comment cannot be empty.");
    }

    $new_comment = trim($_POST['comment']);
    $update_stmt = $pdo->prepare("UPDATE comments SET comment_text = ? WHERE id = ?");
    if ($update_stmt->execute([$new_comment, $comment_id])) {
        header("Location: view_post.php?id=" . $comment['post_id']);
        exit;
    } else {
        die("Error updating comment.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Comment</title>
</head>
<body>
    <h2>Edit Comment</h2>
    <form method="POST">
        <textarea name="comment" required><?= htmlspecialchars($comment['comment_text']) ?></textarea><br>
        <button type="submit">Update</button>
    </form>
    <a href="view_post.php?id=<?= $comment['post_id'] ?>">Cancel</a>
</body>
</html>
