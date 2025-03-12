<?php
require_once "../../includes/auth.php";
require_once "../../model/Product.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

$productId = (int) $_GET['id'];
$product = new Product();

if ($product->deleteProduct($productId)) {
    header("Location: manage_products.php?success=Product deleted successfully");
} else {
    header("Location: manage_products.php?error=Failed to delete product");
}
exit();
