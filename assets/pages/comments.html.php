<!-- comments.php -->
<div class="comments-container">
    <!-- Display comments for this post -->
    <?php
    $postId = $post['post_id'];
    $user = $_SESSION['user'];
    $commentStmt = $pdo->prepare("SELECT c.*, u.username
                                FROM comments c
                                LEFT JOIN users u ON c.user_id = u.user_id
                                WHERE c.post_id = ?
                                ORDER BY c.created_at DESC");
    $commentStmt->execute([$postId]);
    $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $comment) {
        $isCommentOwner = $comment['user_id'] == $user['user_id'];

        echo '<div class="comment pb-2 ps-5 pe-5 d-flex align-items-center">
                <strong class="pe-2">' . $comment['username'] . ': </strong>
                <div>' . $comment['comment_text'] . '</div>
                ';

        // Display delete button only for the comment's owner
        if ($isCommentOwner) {
            echo '<form class="ps-2" method="post" action="assets/php/deletecomments.php">
                    <input type="hidden" name="comment_id" value="' . $comment['comment_id'] . '">
                    <button class="btn-outline-danger btn" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" type="submit" name="delete_comment">Delete</button>
                </form>';
        }

        echo '<hr></div>';
    }
    ?>
    <div class="input-group p-2 border-top">
        <form method="post" action="assets/php/addcomments.php">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            <input type="text" class="form-control rounded-0 border-0" name="comment_text" placeholder="Add a comment..." aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-primary rounded-0 border-0" type="submit" name="add_comment">Post</button>
        </form>
    </div>
</div>
