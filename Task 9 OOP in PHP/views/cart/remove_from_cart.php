<?php
require_once "../../includes/auth.php";

if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}

if (!isset($_POST['product_id'])) {
    echo "Error: Invalid request.";
    exit();
}

$productId = (int) $_POST['product_id'];

if (isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
    header("Location: view_cart.php?success=Product removed from cart");
} else {
    header("Location: view_cart.php?error=Product not found in cart");
}
exit();
