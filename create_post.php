<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please <a href='login.php'>login</a> first.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $user_id]);

    echo "Post created! <a href='index.php'>Go back</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
</head>
<body>
    <h2>Create a New Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Post Title" required><br>
        <textarea name="content" placeholder="Write your post..." required></textarea><br>
        <button type="submit">Publish</button>
    </form>
    <a href="index.php">Back to Home</a>
</body>
</html>
