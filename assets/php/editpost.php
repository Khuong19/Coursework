<?php
include 'DatabaseConnection.php';

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_post'])) {
    // Retrieve form data
    $postId = $_POST["post_id"];
    $newPostTitle = $_POST['new_post_title'];

    // Update the post title in the database
    $stmt = $pdo->prepare("UPDATE posts SET post_text = ? WHERE post_id = ?");
    
    // Execute the statement with proper error handling
    try {
        $stmt->execute([$newPostTitle, $postId]);
        header("Location: ../../?posts");
        exit();
    } catch (PDOException $e) {
        echo 'Error executing the query: ' . $e->getMessage();
    }
}
?>