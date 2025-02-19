<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please <a href='login.php'>login</a>.");
}

if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    die("Invalid post. <a href='index.php'>Go back</a>");
}

$post_id = $_GET['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Comment</title>
</head>
<body>
    <h2>Add a Comment</h2>
    
<form method="POST" action="process_comment.php">
    <label>Post ID (debug): <?= htmlspecialchars($post_id) ?></label><br>
    <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
    <textarea name="comment" placeholder="Write your comment..." required></textarea><br>
    <button type="submit">Submit Comment</button>
</form>

    <a href="view_post.php?id=<?= htmlspecialchars($post_id) ?>">Back to Post</a>
</body>
</html>
