<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - E-Commerce</title>
</head>
<body>
    <h1>Welcome to Our E-Commerce Store</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php
        $user_id = $_SESSION['user_id'];
        $user = $conn->query("SELECT name FROM users WHERE id = $user_id")->fetch_assoc();
        ?>
        <p>Welcome, <?php echo htmlspecialchars($user['name']); ?>! <a href="logout.php">Logout</a></p>
        <p><a href="orders.php">View Order History</a></p>
    <?php else: ?>
        <p><a href="register.php">Register</a> | <a href="login.php">Login</a></p>
    <?php endif; ?>

    <h2>Products</h2>
    <?php
    $result = $conn->query("SELECT * FROM products LIMIT 5");
    if ($result->num_rows > 0):
    ?>
        <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['name']); ?></strong> - $<?php echo $row['price']; ?>
                <a href="cart.php?add=<?php echo $row['id']; ?>">Add to Cart</a>
            </li>
        <?php endwhile; ?>
        </ul>
        <p><a href="products.php">View All Products</a></p>
    <?php else: ?>
        <p>No products available yet.</p>
    <?php endif; ?>
</body>
</html>
