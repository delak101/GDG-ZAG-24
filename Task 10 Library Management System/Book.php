<?php
require_once "db.php";

class Book {
    public $id;
    public $title;
    public $author;
    public $isAvailable;

    public function __construct($id, $title, $author, $isAvailable) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isAvailable = $isAvailable;
    }

    public function displayDetails() {
        echo "ID: $this->id | Title: $this->title | Author: $this->author | Available: " . ($this->isAvailable ? "Yes" : "No") . "<br>";
    }

    public function markAsBorrowed($conn) {
        $conn->query("UPDATE books SET isAvailable = 0 WHERE id = $this->id");
        $this->isAvailable = false;
    }

    public function markAsReturned($conn) {
        $conn->query("UPDATE books SET isAvailable = 1 WHERE id = $this->id");
        $this->isAvailable = true;
    }
}
?>
