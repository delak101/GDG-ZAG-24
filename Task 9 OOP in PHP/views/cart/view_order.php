<?php
require_once "../../includes/auth.php";
require_once "../../connection/DB.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    echo "Error: No order selected.";
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$order_id = (int) $_GET['order_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "Error: Order not found.";
    exit();
}

// Fetch order items
$stmt = $conn->prepare("SELECT p.name, oi.quantity, oi.price FROM order_items oi 
                        JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<h2>Order Details</h2>
<p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
<p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>

<h3>Items</h3>
<table border="1">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php while ($item = $items->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>$<?php echo number_format($item['price'], 2); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="orders.php">Back to Orders</a>
<a href="dashboard.php">Back to Dashboard</a>
