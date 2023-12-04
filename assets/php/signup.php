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
    $adminStatus = isset($_POST["is_admin"]) ? $_POST["is_admin"] : 0; // Default to 0 (user) if not set


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
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password,profile_pic, is_admin) VALUES (?, ?, ?,'default_profile.jpg', ?)");
    $stmt->execute([$username, $email, $password, $adminStatus]);

    // Redirect to a success page or login page
    header("Location: ../../?login");
    exit();
}
?>