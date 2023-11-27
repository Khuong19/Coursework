<?php
// Start the session
session_start();

include 'DatabaseConnection.php';
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newEmail = $_POST["new_email"];
    $newUsername = $_POST["new_username"];
    $newPassword = password_hash($_POST["new_password"], PASSWORD_BCRYPT); // Hash the new password for security

    
    // Check if the email or username has changed before updating
    if ($newEmail != $_SESSION['user']['email'] || $newUsername != $_SESSION['user']['username']) {
        $stmt = $pdo->prepare("UPDATE users SET email = ?, username = ? WHERE id = ?");
        $stmt->execute([$newEmail, $newUsername, $_SESSION['user']['id']]);
    }

    // Check if a new password is provided
    if (!empty($_POST["new_password"])) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newPassword, $_SESSION['user']['id']]);
    }

    // Update the session variable with the new user data
    $_SESSION['user']['email'] = $newEmail;
    $_SESSION['user']['username'] = $newUsername;

    // Redirect to a success page or the profile page
    header("Location: ../../?posts");
    exit();
}
?>