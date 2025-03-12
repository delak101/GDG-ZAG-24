<?php
require_once "../../includes/auth.php";
require_once "../../connection/DB.php";

$db = new Database();
$conn = $db->getconnection();

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<h2>Products</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><a href="view_product.php?product_id=<?php echo $product['id']; ?>">
                <?php echo htmlspecialchars($product['name']); ?>
            </a></td>
            <td>$<?php echo number_format($product['price'], 2); ?></td>
            <td>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="view_cart.php">View Cart</a>
<a href="dashboard.php">Back to Dashboard</a>
