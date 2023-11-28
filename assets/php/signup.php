<?php

include 'DatabaseConnection.php';
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password for security

    // Check if the username or email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // User already exists
        $_SESSION['signup_error'] = 'Username or email already exists';
        header("Location: ../../?signup");
        exit();
    }

    // Insert user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    // Redirect to a success page or login page
    header("Location: ../../?login");
    exit();
}
?>