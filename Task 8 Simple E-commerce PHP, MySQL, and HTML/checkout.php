<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='products.php'>Shop Now</a>";
    exit();
}

$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();
    $total_price += $product['price'] * $quantity;
}

$conn->query("INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total_price)");
$order_id = $conn->insert_id;

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();
    $price = $product['price'];

    $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)");
}

$_SESSION['cart'] = [];

echo "Order placed successfully! <a href='index.php'>Return to Home</a>";
?>
