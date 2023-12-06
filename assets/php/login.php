<?php

include 'DatabaseConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"]; 
    $password = $_POST["password"];


    // Retrieve user from the database based on the provided username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $user;
        if ($user['is_admin']) {
            // Redirect to the admin dashboard
            header("Location: http://localhost/coursework/?dashboard");
        } else {
            // Redirect to the normal posts page
            header("Location: ../../?posts");
        }
        exit();
    } else {
        // Login failed
        $_SESSION['login_error'] = 'Invalid username or password';
        header("Location: ../../?login");
        exit();
    }
}
?>