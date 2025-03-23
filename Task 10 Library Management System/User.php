<?php
require_once "db.php";
require_once "Book.php";

class User {
    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function borrowBook($book, $conn) {
        if (!$book->isAvailable) {
            echo "Book is not available for borrowing.<br>";
            return;
        }

        $conn->query("INSERT INTO borrow_records (user_id, book_id) VALUES ($this->id, $book->id)");
        $book->markAsBorrowed($conn);
        echo "$this->name borrowed '$book->title'.<br>";
    }

    public function returnBook($book, $conn) {
        $checkBorrow = $conn->query("SELECT id FROM borrow_records WHERE user_id = $this->id AND book_id = $book->id");
        
        if ($checkBorrow->num_rows == 0) {
            echo "This book was not borrowed by you.<br>";
            return;
        }

        $conn->query("DELETE FROM borrow_records WHERE user_id = $this->id AND book_id = $book->id");
        $book->markAsReturned($conn);
        echo "$this->name returned '$book->title'.<br>";
    }
}
?>
