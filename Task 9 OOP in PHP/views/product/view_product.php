<?php
session_start();
require_once '../../connection/DB.php';

if (!isset($_GET['product_id'])) {
    echo "Invalid product.";
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$productId = (int) $_GET['product_id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<p>Price: $<?php echo number_format($product['price'], 2); ?></p>
<p>Description: <?php echo htmlspecialchars($product['description']); ?></p>

<form action="add_to_cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" value="1" min="1" required>
    <button type="submit">Add to Cart</button>
</form>

<a href="products.php">Back to Products</a>
<a href="view_cart.php">View Cart</a>
<a href="dashboard.php">Back to Dashboard</a>
