<?php
include 'DatabaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Retrieve user information for editing
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Redirect if the user does not exist
        header("Location: ../../?admin");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
        // Handle the edit form submission
        $newUsername = $_POST['new_username'];
        $newEmail = $_POST['new_email'];

        // Update the user information
        $updateStmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $updateStmt->execute([$newUsername, $newEmail, $userId]);

        // Redirect back to the admin dashboard after editing
        header("Location: ../../?admin");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        // Handle the delete form submission
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $deleteStmt->execute([$userId]);

        // Redirect back to the admin dashboard after deleting
        header("Location: ../../?admin");
        exit();
    }
} else {
    // Redirect for invalid or missing user ID
    header("Location: ../../?admin");
    exit();
}
?>

