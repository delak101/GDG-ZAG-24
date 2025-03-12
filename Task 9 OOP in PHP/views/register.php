<?php
require_once "../model/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->register($name, $email, $password)) {
        echo "Registration successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Registration failed.";
    }
}
?>
<form method="post">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button> <a href="login.php">Already have an account? Login</a>
</form>
