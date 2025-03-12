<?php
session_start();
require_once '../../model/Cart.php';

if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    echo "Error: Invalid request.";
    exit();
}

$productId = (int) $_POST['product_id'];
$quantity = (int) $_POST['quantity'];

if ($quantity <= 0) {
    echo "Error: Quantity must be at least 1.";
    exit();
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart or update quantity
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] += $quantity;
} else {
    $_SESSION['cart'][$productId] = $quantity;
}

// Redirect to cart page
header("Location: view_cart.php");
exit();
