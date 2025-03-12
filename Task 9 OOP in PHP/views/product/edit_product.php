<?php
require_once "../../includes/auth.php";
require_once "../../model/Product.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}

$product = new Product();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

$productId = (int) $_GET['id'];
$productData = $product->getProductById($productId);

if (!$productData) {
    die("Product not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if ($product->updateProduct($productId, $name, $description, $price)) {
        header("Location: manage_products.php?success=Product updated");
    } else {
        echo "<p style='color:red;'>Failed to update product.</p>";
    }
}
?>

<h2>Edit Product</h2>
<form method="post">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($productData['name']); ?>" required><br>

    <label>Description:</label>
    <input type="text" name="description" value="<?php echo htmlspecialchars($productData['description']); ?>" required><br>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" value="<?php echo $productData['price']; ?>" required><br>

    <button type="submit">Update Product</button>
</form>

<a href="manage_products.php">Back to Products</a>
<a href="dashboard.php">Back to Dashboard</a>