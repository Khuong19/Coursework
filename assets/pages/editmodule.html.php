<?php
include 'assets/php/DatabaseConnection.php';

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../../?login");
    exit();
}
?>

<div class="container rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <h1 class="h5 text-center mb-3 fw-normal">Your Modules</h1>

        <?php
        // Retrieve modules for the user
        $stmt = $pdo->prepare("SELECT * FROM modules WHERE user_id = ?");
        $stmt->execute([$user['user_id']]);
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'edit_module_modal.html.php';

        foreach ($modules as $module) {
            echo '<div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">' . $module['module_name'] . '</h5>
                        <p class="card-text">Module ID: ' . $module['module_id'] . '</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModuleModal' . $module['module_id'] . '">Edit Module</button>
                        
                        <form method="post">
                            <input type="hidden" name="delete_module_id" value="' . $module['module_id'] . '">
                            <button class="btn btn-danger" type="submit" name="delete_module">Delete Module</button>
                        </form>
                    </div>
                </div>';
        }

        // Handle delete module
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_module'])) {
            $deleteModuleId = $_POST["delete_module_id"];

            // Delete the module from the database
            $deleteStmt = $pdo->prepare("DELETE FROM modules WHERE module_id = ? AND user_id = ?");
            $deleteStmt->execute([$deleteModuleId, $user['user_id']);

            echo '<script>
                    alert("Module deleted successfully!");
                    window.location.href = window.location.href;
                  </script>';
            exit();
        }
        ?>

        <form method='post'>
            <div class="form-floating mt-1">
                <input type="text" class="form-control rounded-0" name="new_module_name" placeholder="Module Name">
                <label for="floatingInput">New Module Name</label>
            </div>

            <div class="mt-3 d-flex justify-content-center align-items-center">
                <button class="btn btn-primary" type="submit" name="add_module">Add Module</button>
            </div>
        </form>

        <?php
        // Check if the add module form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_module'])) {
            // Retrieve form data
            $newModuleName = $_POST['new_module_name'];

            // Insert the new module into the database
            $stmt = $pdo->prepare("INSERT INTO modules (module_name, user_id) VALUES (?, ?)");
            $stmt->execute([$newModuleName, $user['user_id']]);

            echo '<script>
                    alert("Module added successfully!");
                    window.location.href = window.location.href; // Refresh the page
                  </script>';
            exit();
        }
        ?>
    </div>
</div>
