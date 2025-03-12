<?php
require_once "../../includes/auth.php";
require_once "../../connection/DB.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnection();
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<h2>Your Orders</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Total Price</th>
        <th>Date</th>
        <th>Details</th>
    </tr>
    <?php while ($order = $orders->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['created_at']; ?></td>
            <td><a href="view_order.php?order_id=<?php echo $order['id']; ?>">View</a></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>