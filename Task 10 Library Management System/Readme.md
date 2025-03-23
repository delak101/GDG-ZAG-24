## **How It Works**

1. **Database Setup:** Run the SQL script to create the tables.
    ```sql
    CREATE DATABASE library_db;

    USE library_db;

    CREATE TABLE books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        isAvailable BOOLEAN DEFAULT TRUE
    );

    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );

    CREATE TABLE borrow_records (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        book_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (book_id) REFERENCES books(id)
    );
    ```

2. **Library Class:** Manages book addition, removal, listing, and searching.

3. **Book Class:** Represents books, including marking as borrowed or returned.

4. **User Class:** Allows users to borrow and return books while checking availability.

5. **Example Usage (`index.php`):**
   - Adds books.
   - Lists available books.
   - Borrows and returns books.
   - Shows updated book availability.