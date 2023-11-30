<?php
include 'assets/php/DatabaseConnection.php';
session_start();
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../../?login");
    exit();
}

try {

        $sql = "SELECT module_name, module_id FROM modules WHERE user_id = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$user['user_id']]);
        $modules = $query->fetchAll();
    
    } catch (PDOException $e) {
        echo 'Error fetching modules: ' . $e->getMessage();
    }
?>

<div class="container mt-5 pt-5">
    <div class="mt-4">
        <h5>Add New Post</h5>
    </div>
    <form method="post" action="assets/php/addpost.php" enctype="multipart/form-data">
        <select class="form-select" name="module_id">
            <option selected>Select Module</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?php echo $module['module_id']; ?>">
                    <?php echo $module['module_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="my-3">
            <input class="form-control" type="file" accept=".jpg" name='post_image' id="select_post_img" onchange="displayImage(this)">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
            <textarea class="form-control" name='post_text' id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name='postBtn'>Post</button>
    </form>
</div>


