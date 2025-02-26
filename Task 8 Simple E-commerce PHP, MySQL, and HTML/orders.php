<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
</head>
<body>
    <h1>Your Orders</h1>
    <a href="index.php">Home</a> | <a href="products.php">Shop</a> | <a href="cart.php">Cart</a>

    <?php if ($orders->num_rows > 0): ?>
        <ul>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <li>
                    <strong>Order ID:</strong> <?php echo $order['id']; ?> | 
                    <strong>Total Price:</strong> $<?php echo $order['total_price']; ?> |
                    <strong>Placed On:</strong> <?php echo $order['created_at']; ?> |
                    <a href="order_details.php?order_id=<?php echo $order['id']; ?>">View Details</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have no past orders.</p>
    <?php endif; ?>
</body>
</html>
