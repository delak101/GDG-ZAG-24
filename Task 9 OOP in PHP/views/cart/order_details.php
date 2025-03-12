<?php
require_once '../../model/Order.php';
require_once "../../includes/auth.php";

$orderId = $_GET['order_id'];
$order = new Order();
$details = $order->getOrderDetails($orderId);

echo "<h2>Order Details</h2>";
foreach ($details as $item) {
    echo "{$item['name']} - Quantity: {$item['quantity']} - Price: {$item['price']}<br>";
}
?>
