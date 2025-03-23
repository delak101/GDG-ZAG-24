# E-Commerce System with PHP & MySQL

## **Project Overview**
This project is a simple **E-Commerce System** built using **PHP, HTML & MySQL**, featuring user authentication, product listing, a shopping cart, and an order checkout system.

## **Features**
### **1. Visitors (Unregistered Users)**
- Can view product listings.
- Can register an account.

### **2. Registered Users**
- Can log in and log out.
- Can add products to the cart.
- Can update the quantity or remove items from the cart.
- Can place orders.
- Can view their order history.

### **3. Admin Users**
- Can manage products.
- Can view all orders.
- Can manage users.

## **Installation & Setup**

### **1. Clone the Repository**
```bash
  git clone https://github.com/YOUR_GITHUB/ecommerce-system.git
  cd ecommerce-system
```

### **2. Setup the Database**
- Create a database named **ecommerce_system**.
- Import the `ecommerce_db.sql` file or run the following SQL commands to create the necessary tables.

#### **Database Schema**
```sql
CREATE DATABASE ecommerce_system;
USE ecommerce_system;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

### **3. Sample Data for Quick Setup**
```sql
INSERT INTO products (name, description, price) VALUES
('Laptop', 'High-performance laptop.', 1200.00),
('Smartphone', 'Latest model smartphone.', 800.00),
('Headphones', 'Noise-cancelling headphones.', 200.00);
```

### **4. Configure Database Connection**
- Open `db.php` and update the database credentials:
```php
$host = "localhost";
$dbname = "ecommerce_system";
$username = "root";
$password = "";
```

### **5. Start the Development Server**
- If using **XAMPP**, place the project folder inside `htdocs`.
- Start **Apache** and **MySQL** in XAMPP.
- Open your browser and navigate to:
  ```
  http://localhost/ecommerce/index.php
  ```

## **How to Use**
1. **Register an account** or log in with an existing account.
2. **Browse products** and add items to the cart.
3. **Update your cart** (change quantities or remove items).
4. **Checkout** to place an order.
5. **View your order history.**


