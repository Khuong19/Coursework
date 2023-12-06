<?php
include 'DatabaseConnection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: http://localhost/coursework/?login");
    exit();
} else {
    $user = $_SESSION['user'];
}

// Check if the user_id is set in the POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $userId = $_POST['user_id'];

    try {
        // Retrieve user information for editing
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Delete user
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $deleteStmt->execute([$userId]);

        header("Location: http://localhost/coursework/?dashboard");
        exit();
    } catch (PDOException $e) {
        echo 'Error executing the query: ' . $e->getMessage();
    }
} else {
    echo 'User ID not provided or invalid request method';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['delete_module'])) {
        // Handle module deletion
        $deleteModuleId = $_POST['delete_module_id'];

        try {
            // Delete the module from the database
            $deleteStmt = $pdo->prepare("DELETE FROM modules WHERE module_id = ?");
            $deleteStmt->execute([$deleteModuleId]);

            echo json_encode(['success' => true, 'message' => 'Module deleted successfully']);
            exit();
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error deleting module: ' . $e->getMessage()]);
            exit();
        }
    }

    if (isset($_POST['change_admin'])) {
        $userId = $_POST['user_id'];
        $isAdmin = $_POST['is_admin'];
    
        try {
            // Update the admin status in the database
            $updateStmt = $pdo->prepare("UPDATE users SET is_admin = ? WHERE user_id = ?");
            $updateStmt->execute([$isAdmin, $userId]);
    
            // Redirect back to the dashboard or refresh the page
            header("Location: http://localhost/coursework/?dashboard");
            exit();
        } catch (PDOException $e) {
            echo 'Error updating admin status: ' . $e->getMessage();
        }
    }
}
?>
