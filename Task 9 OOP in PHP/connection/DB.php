<?php
class Database {
    private $host = "localhost";
    private $db_name = "ecommerce_system";
    private $username = "root"; // Change as needed
    private $password = ""; // Change as needed
    private $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Check for connection error
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
?>
