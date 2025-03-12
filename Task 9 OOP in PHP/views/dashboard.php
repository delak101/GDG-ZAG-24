<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../includes/auth.php";
require_once "../model/Product.php";
require_once "../model/Order.php";
require_once "../includes/auth.php";

$product = new Product();
$products = $product->getProducts();

$order = new Order();
$orders = $order->getUserOrders($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <nav>
        <a href="view_products.php">Products</a> | 
        <a href="view_cart.php">View Cart</a> | 
        <a href="order_history.php">Order History</a> | 
        <?php if ($_SESSION['is_admin'] == 1): ?>
            <a href="manage_products.php">Manage Products</a> |
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>

    <h3>Available Products</h3>
    <ul>
        <?php foreach ($products as $p) : ?>
            <li>
                <a href="view_product.php?product_id=<?php echo $p['id']; ?>">
                    <?php echo htmlspecialchars($p['name']); ?>
                </a> - $<?php echo number_format($p['price'], 2); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Recent Orders</h3>
    <ul>
        <?php foreach ($orders as $o) : ?>
            <li>
                <a href="view_order.php?order_id=<?php echo $o['id']; ?>">
                    Order #<?php echo $o['id']; ?> - $<?php echo number_format($o['total_price'], 2); ?>
                </a> (<?php echo htmlspecialchars($o['status']? "pending":"ordered"); ?>)
            </li>
        <?php endforeach; ?>
        <form action="checkout_pending_orders.php" method="POST">
            <button type="submit">Checkout Pending Orders</button>
        </form>
    </ul>
</body>
</html>
