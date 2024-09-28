<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, is_admin) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $password, $email, $is_admin]);

    header("Location: login.php");
    exit();
}
?>

<h2>Register</h2>
<form method="POST">
    <input type="text" name="username" required placeholder="Username">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <label>
        <input type="checkbox" name="is_admin"> Register as Admin
    </label>
    <button type="submit" class="button">Register</button>
</form>

<?php include 'includes/footer.php'; ?>