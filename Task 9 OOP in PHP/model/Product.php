<?php
require_once "../connection/DB.php";

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getProducts() {
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createProduct($name, $description, $price) {
        if ($_SESSION['is_admin'] != 1) {
            return false; // Block non-admins
        }
    
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $description, $price);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $price) {
        if ($_SESSION['is_admin'] != 1) {
            return false; // Block non-admins
        }

        $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        if ($_SESSION['is_admin'] != 1) {
            return false;
        }
    
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
}
?>
