<?php
require_once '../connection/DB.php';
require_once 'Cart.php';

class Order {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function placeOrder($userId) {
        $cart = new Cart();
        $cartItems = $cart->getCartItems($userId);

        if (empty($cartItems)) {
            return "Your cart is empty.";
        }

        $totalPrice = array_sum(array_column($cartItems, 'total'));

        $query = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("id", $userId, $totalPrice);
        $stmt->execute();
        $orderId = $stmt->insert_id;

        foreach ($cartItems as $item) {
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiid", $orderId, $item['id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        $cart->clearCart($userId);
        return "Order placed successfully!";
    }

    public function getUserOrders($userId) {
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function getOrderDetails($orderId) {
        $query = "SELECT o.id, o.total_price, o.status, o.created_at, 
                         p.name, oi.quantity, oi.price 
                  FROM orders o
                  JOIN order_items oi ON o.id = oi.order_id
                  JOIN products p ON oi.product_id = p.id
                  WHERE o.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orderDetails = [];
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }
        return $orderDetails;
    }
}
?>
