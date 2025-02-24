<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$post_id = $_GET['id'];

// Fetch the post
$stmt = $pdo->prepare("SELECT user_id, title, content FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}

if ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] !== 'admin') {
    die("Unauthorized action.");
}

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $delete_stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $delete_stmt->execute([$post_id]);
    header("Location: index.php");
    exit;
}

// Handle UPDATE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $updated_title = trim($_POST['title']);
    $updated_content = trim($_POST['content']);

    if (empty($updated_title) || empty($updated_content)) {
        die("Title and content cannot be empty.");
    }

    $update_stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $update_stmt->execute([$updated_title, $updated_content, $post_id]);

    header("Location: view_post.php?id=" . $post_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Delete Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>
        <label>Content:</label><br>
        <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea><br>
        <button type="submit" name="edit">Save Changes</button>
    </form>
    
    <h2>Delete Post</h2>
    <form method="POST">
        <button type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete Post</button>
    </form>
    
    <a href="view_post.php?id=<?= $post_id ?>">Back to Post</a>
</body>
</html>
