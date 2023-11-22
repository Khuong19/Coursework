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

        foreach ($modules as $module) {
            echo '<div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">' . $module['module_name'] . '</h5>
                        <p class="card-text">Module ID: ' . $module['module_id'] . '</p>
                        <a href="#" class="btn btn-primary">Edit Module</a>
                        <a href="#" class="btn btn-danger">Delete Module</a>
                    </div>
                </div>';
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
                  </script>';
            exit();
        }
        ?>
    </div>
</div>
