<?php
include 'db.php';
session_start();

$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h1>Available Products</h1>
    <a href="index.php">Home</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome! <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
    <?php endif; ?>

    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo $row['name']; ?></strong><br>
                <?php echo $row['description']; ?><br>
                Price: $<?php echo $row['price']; ?><br>
                <a href="cart.php?add=<?php echo $row['id']; ?>">Add to Cart</a>
            </li>
            <hr>
        <?php endwhile; ?>
    </ul>
</body>
</html>
