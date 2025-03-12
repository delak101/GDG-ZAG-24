<?php
require_once "../../includes/auth.php";
require_once "../../model/Product.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}

$product = new Product();
$products = $product->getProducts();
?>

<h2>Manage Products</h2>

<!-- Add Product Form -->
<form action="add_product.php" method="post">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" name="price" placeholder="Price" required>
    <button type="submit">Add Product</button>
</form>

<!-- List of Products -->
<table border="1">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $p) : ?>
        <tr>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td>$<?php echo number_format($p['price'], 2); ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $p['id']; ?>">Edit</a>
                <a href="delete_product.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
