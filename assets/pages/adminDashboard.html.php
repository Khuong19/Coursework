<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: http://localhost/coursework/?login");
    exit();
}

include 'assets/php/DatabaseConnection.php';
include 'assets/php/admin_function.php';

// Fetch data for the dashboard
$modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);
$users = $pdo->query("SELECT users.*, COUNT(posts.post_id) AS num_posts, COUNT(modules.module_id) AS num_modules
FROM users 
LEFT JOIN posts ON users.user_id = posts.user_id
LEFT JOIN modules ON users.user_id = modules.user_id
GROUP BY users.user_id")->fetchAll(PDO::FETCH_ASSOC);

?>
    <h1>Welcome, Admin!</h1>

    <h2 class="mt-4">Users</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Module Number</th>
                <th>Post Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#userModulesModal<?= $user['user_id'] ?>">
                        <?= $user['num_modules'] ?>
                    </a>
                </td>
                <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#userPostsModal<?= $user['user_id'] ?>">
                        <?= $user['num_posts'] ?>
                    </a>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="Edit" value="' . $module['module_id'] . '">
                        <button type="submit" name="Edit">Edit</button>
                    </form>
                    
                    <a href="delete_user.php?id=<?= $user['user_id'] ?>">Delete</a>
                </td>
            </tr>

            <!-- Modal for User's Modules -->
            <div class="modal fade" id="userModulesModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="userModulesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userModulesModalLabel">Modules by <?= $user['username'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                                // Fetch user's modules
                                $userModules = $pdo->prepare("SELECT * FROM modules WHERE user_id = ?");
                                $userModules->execute([$user['user_id']]);
                                $modules = $userModules->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <ul>
                                <?php foreach ($modules as $module): ?>
                                    <li><?= $module['module_name'] ?></li>
                                    <!-- Add more details as needed -->
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for User's Posts -->
            <div class="modal fade" id="userPostsModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="userPostsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userPostsModalLabel">Posts by <?= $user['username'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                                // Fetch user's posts
                                $userPosts = $pdo->prepare("SELECT * FROM posts WHERE user_id = ?");
                                $userPosts->execute([$user['user_id']]);
                                $posts = $userPosts->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <ul>
                                <?php foreach ($posts as $post): ?>
                                    <li><?= $post['post_title'] ?></li>
                                    <!-- Add more details as needed -->
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>

