<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'data/users.json';
    $users = json_decode(file_get_contents($file), true);

    $input = trim($_POST['username']);
    $password = $_POST['password'];

    foreach ($users as $user) {
        if (($user['username'] === $input || $user['email'] === $input) &&
            password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        }
    }

    $error = "Invalid username/email or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="POST">
    <h2>Login</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <input type="text" name="username" placeholder="Username or Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</form>
</body>
</html>
