<div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" style="display:none" id='post_image' class="w-100 rounded border">
                <form method="post" action="assets/php/addpost.php" enctype="multipart/form-data">
                    <select class="form-select rounded-0 border-0" name="module_id" aria-label="Select Module">
                        <option selected>Select Module</option>
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
