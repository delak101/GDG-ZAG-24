<?php
require_once "../../includes/auth.php";
require_once "../../connection/DB.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Update all pending orders to "Checked Out"
$stmt = $conn->prepare("UPDATE orders SET status = 'Checked Out' WHERE user_id = ? AND status = 'Pending'");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<p>All pending orders have been checked out successfully!</p>";
} else {
    echo "<p>No pending orders found.</p>";
}

$stmt->close();
$conn->close();
?>

<a href="dashboard.php">Return to Dashboard</a>
