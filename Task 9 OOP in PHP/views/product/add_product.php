<?php
require_once "../../includes/auth.php";
require_once "../../model/Product.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product = new Product();
    if ($product->createProduct($_POST['name'], $_POST['description'], $_POST['price'])) {
        header("Location: manage_products.php?success=Product added");
    } else {
        header("Location: manage_products.php?error=Failed to add product");
    }
    exit();
}
?>
