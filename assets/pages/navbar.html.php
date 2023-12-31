<?php

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: http://localhost/coursework/?login");
    exit();
}

// Check if the logout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {

    // Unset the user session variable
    session_destroy();
    header("Location: http://localhost/coursework/?login");
    exit();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container d-flex justify-content-between">
        <div>
            <img src="assets/php/uploads/LogoCoursework.png" alt="Logo" class="logo-coursework" style="height: 50px;" />
        </div>
        <ul class="d-flex justify-content-evenly navbar-nav mb-2 mb-lg-0">
            <li class="hover-nav-item nav-item px-5 d-flex flex-column align-items-center">
                <a class="nav-link text-dark" href="?posts"><i class="bi bi-house-door-fill"></i></a>
                Home
            </li>
            <li class="hover-nav-item nav-item px-5 d-flex flex-column align-items-center">
                <a class="nav-link text-dark" href="?addpost"><i class="bi bi-plus-square-fill"></i></a>
                Add Post
            </li>
            <li class="hover-nav-item nav-item px-5 d-flex flex-column align-items-center">
                <a class="nav-link text-dark" href="?sendmail"><i class="bi bi-envelope-arrow-up-fill"></i></a>
                Contact to Admin
            </li>
        </ul>
        <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./assets/php/uploads/<?=$user['profile_pic']?>" alt="" height="30" class="rounded-circle border">
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?editProfile">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="?editmodule">Edit Module</a></li>
                    <li><a class="dropdown-item" href="?">Welcomed Page</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <!-- Use a form to submit the logout request -->
                        <form method='post'>
                            <button type="submit" name="logout" class="btn nav-link text-dark">
                                Log out
                            </button>
                        </form>
                    </li>
                </ul>
        </div>
    </div>
</nav>
