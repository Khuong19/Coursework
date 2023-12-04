<?php
// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: http://localhost/coursework/?login");
    exit();
}
?>
<div class="container rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <form method='post' action='assets/php/editUser.php' enctype="multipart/form-data">

            <h1 class="h5 text-center mb-3 fw-normal">Edit Profile</h1>
            <div class="form-floating mt-1">
                <img src="assets/php/uploads/<?=$user['profile_pic']?>" class="img-thumbnail my-3" style="height:150px;" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" type="file" id="formFile" name="new_profile_pic">
                </div>
            </div>
            
            <div class="input-group mt-2">
                <span class="input-group-text">Email</span>
                <input type="email" class="form-control rounded-0" name="new_email" value="<?=$user['email']?>">
            </div>
            <div class="input-group mt-2">
                <span class="input-group-text">Username</span>
                <input type="text" class="form-control rounded-0" name="new_username" value="<?=$user['username']?>">
            </div>
            <div class="input-group mt-2">
                <span class="input-group-text">Password</span>
                <input type="password" class="form-control rounded-0" name="new_password" id="floatingPassword" placeholder="Password">
            </div>

            <div class="mt-3 d-flex justify-content-center align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>

        </form>
    </div>
</div>
