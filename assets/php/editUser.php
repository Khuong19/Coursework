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
        $stmt = $pdo->prepare("UPDATE users SET email = ?, username = ? WHERE user_id = ?");
        $stmt->execute([$newEmail, $newUsername, $_SESSION['user']['user_id']]);
    }
    // Check if a new username is provided
    if (!empty($_POST["new_username"])) {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE user_id = ?");
        $stmt->execute([$_POST["new_username"], $_SESSION['user']['user_id']]);
    }

    // Check if a new email is provided
    if (!empty($_POST["new_email"])) {
        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE user_id = ?");
        $stmt->execute([$_POST["new_email"], $_SESSION['user']['user_id']]);
    }
    // Check if a new password is provided
    if (!empty($_POST["new_password"])) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->execute([$newPassword, $_SESSION['user']['user_id']]);
    }

    // Check if a new profile_pic is provided
    if (!empty($_FILES['new_profile_pic']['name'])) {
        // Handle file upload
        $targetDir = 'uploads/';
        
        // Construct a unique filename
        $filename = $uploadDir . basename($_FILES['new_profile_pic']['name'], $filename);

        $uploadFile = $_FILES['new_profile_pic']['name'];

        if (move_uploaded_file($_FILES['new_profile_pic']['tmp_name'], $filename)) {
            // Update the profile_pic in the database
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE user_id = ?");
            $stmt->execute([$uploadFile, $_SESSION['user']['user_id']]);
        } else {
            // Handle file upload error
            echo "File upload failed.";
            exit();
        }
    }

    // Update the session variable with the new user data
    $_SESSION['user']['email'] = $newEmail;
    $_SESSION['user']['username'] = $newUsername;

    // Redirect to a success page or the profile page
    header("Location: ../../?posts");
    exit();
}
?>
