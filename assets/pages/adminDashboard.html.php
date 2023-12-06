<?php
include 'assets/php/DatabaseConnection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: http://localhost/coursework/?login");
    exit();
}

// Fetch data for the dashboard
$modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);
$users = $pdo->query("SELECT users.*, COUNT(posts.post_id) AS num_posts, COUNT(modules.module_id) AS num_modules
FROM users 
LEFT JOIN posts ON users.user_id = posts.user_id
LEFT JOIN modules ON users.user_id = modules.user_id
GROUP BY users.user_id")->fetchAll(PDO::FETCH_ASSOC);


?>
    <table class=" table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Modules</th>
                <th>Posts</th>
                <th>Admin Status</th>
                <th>Delete User</th>
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
                    <form method="post" action="assets/php/admin_function.php" class="d-flex justify-content-evenly">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <select name="is_admin" class="form-select w-50 d-inline-block">
                            <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>User</option>
                            <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <button class="btn btn-primary" type="submit" name="change_admin">Change</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="assets/php/admin_function.php">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                    </form>
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
                                    <li class="text-decoration-none">
                                        <?= $module['module_name'] ?>
                                        <!-- Add more details as needed -->
                                    </li>
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

