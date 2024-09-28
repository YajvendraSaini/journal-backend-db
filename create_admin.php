<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

// Check if the current user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // We'll hash this later

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 1)");
        if ($stmt->execute([$username, $email, $password_hash])) {
            $success = "Admin user created successfully.";
        } else {
            $error = "Error creating admin user.";
        }
    }
}
?>

<h2>Create Admin User</h2>
<?php
if (isset($error)) echo "<p class='error'>$error</p>";
if (isset($success)) echo "<p class='success'>$success</p>";
?>
<form method="POST">
    <input type="text" name="username" required placeholder="Username">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" class="button">Create Admin</button>
</form>

<?php include 'includes/footer.php'; ?>