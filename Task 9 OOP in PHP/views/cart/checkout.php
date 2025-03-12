<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>

    <?php
    require_once "../../includes/auth.php";
    require_once "../../connection/DB.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty. <a href='products.php'>Shop Now</a></p>";
        exit();
    }

    $db = new Database();
    $conn = $db->getConnection();

    $total_price = 0;
    $order_items = [];

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_id = (int) $product_id;
        $quantity = (int) $quantity;

        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $price = $product['price'];
            $total_price += $price * $quantity;
            $order_items[] = ['id' => $product_id, 'quantity' => $quantity, 'price' => $price];
        }
    }

    // Insert order and set status to 'Checked Out'
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Checked Out')");
    $stmt->bind_param("id", $_SESSION['user_id'], $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order items using batch execution
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($order_items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }
    $stmt->close();

    // Clear the cart after checkout
    unset($_SESSION['cart']);
    $conn->close();
    ?>

    <p>Your order has been placed successfully!</p>
    <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
    <p><strong>Total Price:</strong> $<?php echo number_format($total_price, 2); ?></p>

    <h2>Order Summary</h2>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['id']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">Return to Home</a>
</body>
</html>
