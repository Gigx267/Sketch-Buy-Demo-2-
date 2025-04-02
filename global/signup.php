<?php
include("../config/connect.php"); // Ensure correct path to the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        die("Email already exists! Try logging in.");
    }

    // Insert new user into the database
    $query = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $query->bind_param("sss", $name, $email, $hashed_password);

    if ($query->execute()) {
        echo "Registration successful! Redirecting to login...";
        header("refresh:2;url=../login.html");
        exit();
    } else {
        echo "Error: " . $query->error;
    }

    // Close connections
    $check_email->close();
    $query->close();
    $conn->close();
}
?>
