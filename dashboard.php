<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
echo "Welcome, " . htmlspecialchars($_SESSION['user']) . "!<br>";
echo "<a href='logout.php'>Logout</a>";
?>
