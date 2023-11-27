
<div class="modal fade" id="editModuleModal<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <input type="hidden" name="edit_module_id" value="<?= $module['module_id'] ?>">
                    <div class="form-floating mt-1">
                        <input type="text" class="form-control rounded-0" name="edited_module_name" placeholder="Module Name" value="<?= $module['module_name'] ?>">
                        <label for="floatingInput">Edited Module Name</label>
                    </div>
                    <div class="mt-3 d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary" type="submit" name="update_module">Update Module</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>