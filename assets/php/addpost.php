<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'DatabaseConnection.php';

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    header("Location: http://localhost/coursework/?login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postBtn'])) {
    // Retrieve form data
    $postTitle = $_POST["post_title"];
    $moduleId = $_POST["module_id"];
    $postContent = $_POST["post_content"];

    // Check if a file is selected
    if (!empty($_FILES['post_image']['name'])) {
        $targetDir = 'uploads/';
        $filename = $targetDir . basename($_FILES['post_image']['name']);

        // Check if file upload was successful
        if ($_FILES['post_image']['error'] !== UPLOAD_ERR_OK) {
            echo 'Error uploading file. Please try again.';
        } else {
            // Check if file already exists
            if (file_exists($filename)) {
                echo "Sorry, file already exists.";
            } else {
                // Attempt to upload the file
                if (move_uploaded_file($_FILES['post_image']['tmp_name'], $filename)) {
                    // Store the file name for later use
                    $uploadedPictureName = $_FILES['post_image']['name'];

                    // Update the database with the file name and post text
                    $stmt = $pdo->prepare("INSERT INTO posts (user_id, post_title, post_content, post_img, module_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

                    // Execute the statement with proper error handling
                    try {
                        $stmt->execute([$user['user_id'], $postTitle,$postContent, $uploadedPictureName, $moduleId]);
                        header("Location: ../../?posts");
                        exit();
                    } catch (PDOException $e) {
                        echo 'Error executing the query: ' . $e->getMessage();
                    }
                } else {
                    // Handle file upload error
                    echo 'Error uploading file';
                }
            }
        }
    } else {
        // Update the database with only the post text
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, post_title, post_content, module_id, created_at) VALUES (?, ?, ?, ?, NOW())");

        // Execute the statement with proper error handling
        try {
            $stmt->execute([$user['user_id'], $postText, $postContent, $moduleId]);
            header("Location: ../../?posts");
            exit();
        } catch (PDOException $e) {
            echo 'Error executing the query: ' . $e->getMessage();
        }
    }
}
?>
