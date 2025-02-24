<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog System</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 50%; margin: auto; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; margin: 0 10px; text-decoration: none; }
        .logout { color: red; }
        .button { display: inline-block; padding: 10px; margin: 10px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="create_post.php">New Post</a>
        <a href="logout.php" class="logout">Logout</a>
        <span style="color:white;">(<?= $_SESSION['role'] ?>)</span>
    <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

<div class="container">
    <h1>Welcome to the Blog System</h1>
    <p>Read posts, comment, and share your thoughts!</p>
    
    <h2>Recent Posts</h2>
    <?php
    require 'db.php';
    $stmt = $pdo->query("SELECT posts.id, posts.title, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 5");
    while ($post = $stmt->fetch()):
    ?>
        <div>
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p>by <?= htmlspecialchars($post['name']) ?></p>
            <a class="button" href="view_post.php?id=<?= $post['id'] ?>">Read More</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
