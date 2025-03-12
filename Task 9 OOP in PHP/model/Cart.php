<?php
require_once '../connection/DB.php';

class Cart {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function addToCart($userId, $productId, $quantity) {
        $query = "INSERT INTO carts (user_id, product_id, quantity) 
                  VALUES (?, ?, ?) 
                  ON DUPLICATE KEY UPDATE quantity = quantity + ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $userId, $productId, $quantity, $quantity);
        return $stmt->execute();
    }

    public function getCartItems($userId) {
        $query = "SELECT c.id, p.name, p.price, c.quantity, (p.price * c.quantity) AS total 
                  FROM carts c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        return $cartItems;
    }

    public function removeFromCart($userId, $productId) {
        $query = "DELETE FROM carts WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        return $stmt->execute();
    }

    public function clearCart($userId) {
        $query = "DELETE FROM carts WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
}
?>
