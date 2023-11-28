<div class="container" id="addpost" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Post</h5>
            </div>
            <div class="modal-body">
                <img src="" style="display:none" id='post_image' class="w-100 rounded border">
                <form method="post" action="../php/addpost.php" enctype="multipart/form-data">
                    <select class="form-select" name="module_id">

                        <?php foreach ($modules as $module):?>
                            <option value="<?php echo $module['module_id']; ?>">
                                <?php echo $module['module_name']; ?>
                                <?php echo $user['user_id']; ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                    <div class="my-3">
                        <input class="form-control" type="file" accept=".jpg" name='post_image' id="select_post_img" onchange="displayImage(this)">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
                        <textarea class="form-control" name='post_text' id="exampleFormControlTextarea1" rows="1"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name='postBtn'>Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImage(input) {
        var img = document.getElementById('post_image');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.style.display = 'block';
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
