<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    echo "Invalid Order.";
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

$order = $conn->query("SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id")->fetch_assoc();
if (!$order) {
    echo "Order not found.";
    exit();
}

$order_items = $conn->query("SELECT products.name, order_items.quantity, order_items.price 
    FROM order_items 
    JOIN products ON order_items.product_id = products.id 
    WHERE order_items.order_id = $order_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h1>Order Details</h1>
    <a href="orders.php">Back to Orders</a>

    <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
    <p><strong>Total Price:</strong> $<?php echo $order['total_price']; ?></p>
    <p><strong>Placed On:</strong> <?php echo $order['created_at']; ?></p>

    <h2>Items</h2>
    <ul>
        <?php while ($item = $order_items->fetch_assoc()): ?>
            <li><?php echo $item['name']; ?> - <?php echo $item['quantity']; ?> x $<?php echo $item['price']; ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
