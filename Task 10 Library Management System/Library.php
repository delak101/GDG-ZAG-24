<?php
require_once "db.php";
require_once "Book.php";

class Library {
    public $books = [];

    public function addBook($book, $conn) {
        $conn->query("INSERT INTO books (title, author, isAvailable) VALUES ('$book->title', '$book->author', 1)");
        echo "Book '{$book->title}' added successfully.<br>";
    }

    public function removeBook($id, $conn) {
        $conn->query("DELETE FROM books WHERE id = $id");
        echo "Book with ID $id removed.<br>";
    }

    public function listAvailableBooks($conn) {
        $result = $conn->query("SELECT * FROM books WHERE isAvailable = 1");
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id']} | Title: {$row['title']} | Author: {$row['author']}<br>";
        }
    }

    public function findBook($keyword, $conn) {
        $result = $conn->query("SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'");
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id']} | Title: {$row['title']} | Author: {$row['author']}<br>";
        }
    }
}
?>
