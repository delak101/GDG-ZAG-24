<?php
require_once "db.php";
require_once "Library.php";
require_once "User.php";
require_once "Book.php";

$library = new Library();
$user = new User(1, "John Doe");

// Add books
$book1 = new Book(null, "1984", "George Orwell", true);
$book2 = new Book(null, "To Kill a Mockingbird", "Harper Lee", true);

$library->addBook($book1, $conn);
$library->addBook($book2, $conn);

// List available books
echo "<h3>Available Books:</h3>";
$library->listAvailableBooks($conn);

// Borrow a book
$bookToBorrow = new Book(1, "1984", "George Orwell", true);
$user->borrowBook($bookToBorrow, $conn);

// List available books after borrowing
echo "<h3>Available Books After Borrowing:</h3>";
$library->listAvailableBooks($conn);

// Return a book
$user->returnBook($bookToBorrow, $conn);

// List available books after returning
echo "<h3>Available Books After Returning:</h3>";
$library->listAvailableBooks($conn);
?>
