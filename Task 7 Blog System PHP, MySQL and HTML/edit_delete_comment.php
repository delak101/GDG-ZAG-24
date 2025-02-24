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

// Fetch the comment
$stmt = $pdo->prepare("SELECT user_id, comment_text FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
    die("Comment not found.");
}

if ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['role'] !== 'admin') {
    die("Unauthorized action.");
}

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $delete_stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $delete_stmt->execute([$comment_id]);
    header("Location: view_post.php?id=" . $_GET['post_id']);
    exit;
}

// Handle UPDATE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $updated_text = trim($_POST['comment_text']);
    
    if (empty($updated_text)) {
        die("Comment cannot be empty.");
    }

    $update_stmt = $pdo->prepare("UPDATE comments SET comment_text = ? WHERE id = ?");
    $update_stmt->execute([$updated_text, $comment_id]);
    
    header("Location: view_post.php?id=" . $_GET['post_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Delete Comment</title>
</head>
<body>
    <h2>Edit Comment</h2>
    <form method="POST">
        <textarea name="comment_text" required><?= htmlspecialchars($comment['comment_text']) ?></textarea><br>
        <button type="submit" name="edit">Save Changes</button>
    </form>
    
    <h2>Delete Comment</h2>
    <form method="POST">
        <button type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete Comment</button>
    </form>
    
    <a href="view_post.php?id=<?= $_GET['post_id'] ?>">Back to Post</a>
</body>
</html>
