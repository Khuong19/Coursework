<?php
include 'assets/php/DatabaseConnection.php';

// Check if the user is logged in
if (isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    // Access user data
    $stmt = $pdo->prepare("SELECT p.*, m.module_name, u.username, u.profile_pic FROM posts p
    LEFT JOIN modules m ON p.module_id = m.module_id
    LEFT JOIN users u ON p.user_id = u.user_id
    ORDER BY p.created_at DESC"); 
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($posts as $post) {
        $isPostCreator = $_SESSION['user']['user_id'] === $post['user_id'];

        echo '<div class="container col-7 rounded-0 mb-5">
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center p-2">
                                <img src="assets/php/uploads/' . $post['profile_pic'] . '" alt="" height="60" class="rounded-circle border">
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-start">
                                    <h2 style="margin: 0px;">' . $post['post_title'] . '</h2>
                                    <p style="margin:0px;" class="text-muted">Posted by @' . $post['username'] . '</p>
                                    <p style="margin:0px;" class="text-muted">Module Name:' . $post['module_name'] . '</p>
                                </div>
                            </div>';
                            if ($isPostCreator){
                                echo '<div class="p-2">
                                <i class="bi bi-three-dots-vertical dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editPostModal'.$post['post_id'].'">Edit</button>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <form method="post" action="assets/php/deletepost.php">
                                            <input type="hidden" name="post_id" value="'.$post['post_id'].'">
                                            <button class="dropdown-item" type="submit" name="delete_post">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>';
                            }
                            
        echo '</div>

                        <div class="modal fade" id="editPostModal'.$post['post_id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="assets/php/editpost.php">
                                            <input type="hidden" name="post_id" value="'.$post['post_id'].'">
                                            <div class="mb-3">
                                                <label for="new_post_title" class="form-label">New Post Title</label>
                                                <input type="text" class="form-control" id="new_post_title" name="new_post_title" value="'.$post['post_title'].'">
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_post_content" class="form-label">New Post Content</label>
                                                <input type="text" class="form-control" id="new_post_content" name="new_post_content" value="'.$post['post_content'].'">
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_module" class="form-label">Select Module</label>
                                                <select class="form-select" name="module_id">
                                                    ';
                                                // Fetch modules and generate options
                                                $modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($modules as $module) {
                                                    echo '<option value="' . $module['module_id'] . '">' . $module['module_name'] . '</option>';
                                                }

                                                echo '</select>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="edit_post">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="card-body">
                                <p>' . $post['post_content'] . '</p>
                            </div>
                            <img class="img-fluid" src="assets/php/uploads/'.$post['post_img'].'"  alt="'.$post['post_img'].'">
                        </div>';

        // Include comments section from comments.html.php
        include 'assets/pages/comments.html.php';
        echo '</div>
            </div>
        </div>';
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: http://localhost/coursework/?login");
    exit();
}
?>
