<?php
session_start();
require_once '../../connection/DB.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='products.php'>Shop Now</a></p>";
    exit();
}

$total_price = 0;
?>

<h1>Your Cart</h1>
<table border="1">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>

    <?php foreach ($_SESSION['cart'] as $productId => $quantity) :
        $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            continue; // Skip if product not found
        }

        $subtotal = $product['price'] * $quantity;
        $total_price += $subtotal;
    ?>
        <tr>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td>$<?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo $quantity; ?></td>
            <td>$<?php echo number_format($subtotal, 2); ?></td>
            <td>
                <a href="remove_from_cart.php?product_id=<?php echo $productId; ?>">Remove</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><strong>Total Price:</strong> $<?php echo number_format($total_price, 2); ?></p>
<a href="place_order.php">Place Order</a>
<a href="products.php">Continue Shopping</a>
<a href="dashboard.php">Back to Dashboard</a>
<a href="checkout.php">Checkout</a>
