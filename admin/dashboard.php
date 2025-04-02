<?php
session_start();

// Restrict access to only admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit();
}

echo "Welcome to the Admin Dashboard, " . $_SESSION['user_name'];
?>
