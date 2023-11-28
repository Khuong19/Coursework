<?php
include 'DatabaseConnection.php';

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
}

try {
    // Fetch modules inside the condition
    $stmt = $pdo->prepare("SELECT * FROM modules WHERE user_id = ?");
    $stmt->execute([$user['user_id']]);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['postBtn'])) {
        $moduleId = isset($_POST['module_id']) ? $_POST['module_id'] : null;
        $postText = $_POST['post_text'];

        // Check if a file is selected
        if (!empty($_FILES['post_image']['name'])) {
            $targetDir = 'uploads/';
    
            // Check if the directory exists, create it if not
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
    
            $filename = $targetDir . basename($_FILES['post_image']['name']);
    
            // Upload the file
            if (move_uploaded_file($_FILES['post_image']['tmp_name'], $filename)) {
                // Resize the image
                list($width, $height) = getimagesize($filename);
                $newWidth = 300; // Adjust this value as needed
                $newHeight = ($newWidth / $width) * $height;
    
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                $sourceImage = imagecreatefromjpeg($filename);
    
                imagecopyresized($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
                // Save the resized image
                $resizedFilename = $targetDir . 'resized_' . basename($_FILES['post_image']['name']);
                imagejpeg($resizedImage, $resizedFilename);
    
                // Display the resized image
                echo '<script>
                        document.getElementById("post_image").style.display = "block";
                        document.getElementById("post_image").src = "' . $resizedFilename . '";
                        </script>';
    
                // Store the file name for later use
                $uploadedPictureName = 'resized_' . $_FILES['post_image']['name'];
    

                // Update the database with the file name, post text, and module ID
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
                // Handle file upload error
                echo 'Error uploading file';
            }
        } else {
            // Update the database with only the post text and module ID
            $stmt = $pdo->prepare("INSERT INTO posts (post_text, user_id, module_id, created_at) VALUES (?, ?, ?, NOW())");

            // Execute the statement with proper error handling
            try {
                $stmt->execute([$postText, $user['user_id'], $moduleId]);
                header("Location: ../../?posts");
                exit();
            } catch (PDOException $e) {
                echo 'Error executing the query: ' . $e->getMessage();
            }
        }
    }
} catch (PDOException $e) {
    echo 'Error executing the query: ' . $e->getMessage();
}
?>
