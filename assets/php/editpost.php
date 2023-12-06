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
    $newPostContent = $_POST['new_post_content'];
    $moduleId = $_POST['module_id'];

    // Update the post title and content in the database
    $stmt = $pdo->prepare("UPDATE posts SET post_title = ?, post_content = ?, module_id = ? WHERE post_id = ?");
    
    // Execute the statement with proper error handling
    try {
        $stmt->execute([$newPostTitle, $newPostContent, $moduleId, $postId]);
        header("Location: ../../?posts");
        exit();
    } catch (PDOException $e) {
        echo 'Error executing the query: ' . $e->getMessage();
    }
}
?>
