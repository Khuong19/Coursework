<?php
session_start();
include 'DatabaseConnection.php';

function resizeAndSaveImage($source, $target, $newWidth) {
    list($width, $height) = getimagesize($source);
    $newHeight = ($newWidth / $width) * $height;

    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    $sourceImage = imagecreatefromjpeg($source);

    imagecopyresized($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save the resized image
    return imagejpeg($resizedImage, $target);
}

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    header("Location: http://localhost/coursework/?login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postBtn'])) {
    // Retrieve form data
    $postText = $_POST["post_text"];
    $moduleId = $_POST["module_id"];

    // Check if a file is selected
    if (!empty($_FILES['post_image']['name'])) {
        $targetDir = 'uploads/';
        $filename = $targetDir . basename($_FILES['post_image']['name']);

        // Check if file already exists
        if (file_exists($filename)) {
            echo "Sorry, file already exists.";
        } else {
            // Attempt to upload the file
            if (move_uploaded_file($_FILES['post_image']['tmp_name'], $filename)) {
                // Resize the image
                $resizedFilename = $targetDir . 'resized_' . basename($_FILES['post_image']['name']);
                if (resizeAndSaveImage($filename, $resizedFilename, 300)) {
                    // Display the resized image
                    echo '<script>
                            document.getElementById("post_image").style.display = "block";
                            document.getElementById("post_image").src = "' . $resizedFilename . '";
                            </script>';

                    // Store the file name for later use
                    $uploadedPictureName = 'resized_' . $_FILES['post_image']['name'];

                    // Update the database with the file name and post text
                    $stmt = $pdo->prepare("INSERT INTO posts (user_id, post_text, post_img, module_id, created_at) VALUES (?, ?, ?, ?, NOW())");

                    // Execute the statement with proper error handling
                    try {
                        $stmt->execute([$user['user_id'], $postText, $uploadedPictureName, $moduleId]);
                        header("Location: ../../?posts");
                        exit();
                    } catch (PDOException $e) {
                        echo 'Error executing the query: ' . $e->getMessage();
                    }
                } else {
                    // Handle resizing error
                    echo 'Error resizing image';
                }
            } else {
                // Handle file upload error
                echo 'Error uploading file';
            }
        }
    } else {
        // Update the database with only the post text
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, post_text, module_id, created_at) VALUES (?, ?, ?, NOW())");

        // Execute the statement with proper error handling
        try {
            $stmt->execute([$user['id'], $postText, $moduleId]);
            header("Location: ../../?posts");
            exit();
        } catch (PDOException $e) {
            echo 'Error executing the query: ' . $e->getMessage();
        }
    }
}
?>
