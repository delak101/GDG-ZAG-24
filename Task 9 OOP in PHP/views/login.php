<?php
require_once "../model/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    if ($user->login($_POST['email'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
?>
<form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button> <a href="register.php">don't have account? Register</a>
</form>
