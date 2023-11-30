<?php
include 'assets/php/DatabaseConnection.php';
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['admin_status']) {
    header("Location: ../../?login");
    exit();
}

// Fetch data for the dashboard
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);
$posts = $pdo->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);

// Display the dashboard HTML
?>
<h1>Welcome, Admin!</h1>
<h2>Users</h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?= $user['username'] ?> (<?= $user['email'] ?>)
            <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a>
            <a href="delete_user.php?id=<?= $user['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Modules</h2>
<ul>
    <?php foreach ($modules as $module): ?>
        <li>
            <?= $module['module_name'] ?>
            <a href="edit_module.php?id=<?= $module['id'] ?>">Edit</a>
            <a href="delete_module.php?id=<?= $module['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Posts</h2>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <?= $post['post_text'] ?>
            <a href="edit_post.php?id=<?= $post['id'] ?>">Edit</a>
            <a href="delete_post.php?id=<?= $post['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>
