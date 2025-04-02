<?php
session_start();
include("../config/connect.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $query = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();
    
    if ($query->num_rows > 0) {
        $query->bind_result($user_id, $name, $hashed_password);
        $query->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store user details in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            echo "Login successful! Redirecting to dashboard...";
            header("refresh:2;url=../dashboard.html"); // Redirect to dashboard
            exit();
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "No account found with this email!";
    }

    $query->close();
    $conn->close();
}
?>
