<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

echo "Welcome to your User Dashboard, " . $_SESSION['user_name'];
?>
