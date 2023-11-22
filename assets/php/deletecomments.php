<?php
include 'DatabaseConnection.php';

// Check if the comment_id is set and not empty
if (isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
    // Get the comment_id from the POST data
    $commentId = $_POST['comment_id'];

    try {
        // Prepare and execute the DELETE query
        $deleteCommentStmt = $pdo->prepare("DELETE FROM comments WHERE comment_id = ?");
        $deleteCommentStmt->execute([$commentId]);

        // Redirect back to the previous page after deletion
        header("Location: ../../?posts");
        exit();
    } catch (PDOException $e) {
        // Handle the exception (you might want to log the error or show a user-friendly message)
        echo "Error deleting comment: " . $e->getMessage();
    }
} else {
    // Redirect back to the previous page if comment_id is not set or empty
    header("Location: ../../?posts");
    exit();
}
?>
