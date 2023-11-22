<?php
include 'DatabaseConnection.php'; // Update this path based on your file structure

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_comment'])) {
        // Retrieve form data
        $postId = $_POST['post_id'];
        $commentText = $_POST['comment_text'];

        // Insert the new comment into the database
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->execute([$postId, $user['user_id'], $commentText]);
        header("Location: ../../?posts");
        exit();
    } else {
        header("Location: ../../?posts");
        exit();
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../../?login");
    exit();
}
?>
