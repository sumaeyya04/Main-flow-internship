<?php
session_start();
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'data/users.json';
    $users = json_decode(file_get_contents($file), true);

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($email) || empty($password) || $password !== $confirm) {
        $error = "Please fill in all fields and make sure passwords match.";
    } else {
        foreach ($users as $user) {
            if ($user['email'] === $email || $user['username'] === $username) {
                $error = "Username or email already exists.";
                break;
            }
        }

        if (empty($error)) {
            $users[] = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];
            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "Signup successful! <a href='login.php'>Login here</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="POST">
    <h2>Signup</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <input type="submit" value="Sign Up">
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>
