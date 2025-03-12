<?php
require_once "../../includes/auth.php";
require_once "../../connection/DB.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: view_cart.php?error=Your cart is empty.");
    exit();
}

$db = new Database();
$conn = $db->getConnection();
$user_id = $_SESSION['user_id'];
$total_price = 0;
$order_items = [];

// Get product details and calculate total price
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
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

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($order_items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
    $stmt->execute();
}

// Clear cart
$_SESSION['cart'] = [];

header("Location: view_order.php?order_id=$order_id");
exit();
