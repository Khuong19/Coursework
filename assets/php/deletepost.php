<?php
include 'DatabaseConnection.php';

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    // Retrieve form data
    $postId = $_POST['post_id'];

    // Delete the post from the database
    $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
    
    // Execute the statement with proper error handling
    try {
        $stmt->execute([$postId]);
        header("Location: ../../?posts");
        exit();
    } catch (PDOException $e) {
        echo 'Error executing the query: ' . $e->getMessage();
    }
}
?>
