# Blog System with Comments and Admin Role

## **Project Overview**
This project is a simple blog system built with **PHP, HTML & MySQL**, featuring user authentication, role-based access control, and CRUD operations for posts and comments. The system allows users to interact with blog posts based on their assigned roles.

## **Features**
### **1. Visitors (Unregistered Users)**
- Can read all posts.

### **2. Registered Users**
- Can read all posts.
- Can create, edit, and delete their own posts.
- Can comment on any post.
- Can edit or delete their own comments.

### **3. Admin Users**
- Can create, edit, and delete any post.
- Can delete any comment.
- Can manage user roles.

## **Installation & Setup**

### **1. Clone the Repository**
```bash
  git clone https://github.com/YOUR_GITHUB/GDG-ZAG-24.git
  cd GDG-ZAG-24/task-7
```

### **2. Setup the Database**
- Create a database named **blog_system**.
- Import the `blog_db.sql` file or run the following SQL commands to create the necessary tables.

#### **Database Schema**
```sql
CREATE DATABASE blog_db;
USE blog_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('visitor', 'user', 'admin') DEFAULT 'user'
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### **3. Configure Database Connection**
- Open `db.php` and update the database credentials (in case you use password):
```php
$host = "localhost";
$dbname = "blog_db";
$username = "root";
$password = "";
```

### **4. Start the Development Server**
- If using **XAMPP**, place the project folder inside `htdocs`.
- Start **Apache** and **MySQL** in XAMPP.
- Open your browser and navigate to:
  ```
  http://localhost/Blog/index.php
  ```

## **How to Use**
1. **Register an account** or use an existing admin account (psst email is admin@gmail & password is admin).
2. **Login** with your credentials.
3. **Create posts** from the dashboard.
4. **Add comments** to posts.
5. **Edit or delete** your posts and comments.
6. **Admins** can delete posts and comments.

---
**Project by GDG-ZAG-24-CORE**

