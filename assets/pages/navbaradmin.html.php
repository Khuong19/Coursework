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

$currentUsername = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';
?>
<nav class="navbar navbar-expand-lg">
    <div class="container col-12 d-flex justify-content-evenly">
        <div>
            <img src="assets/php/uploads/LogoCoursework.png" alt="Logo" class="logo-coursework" style="height: 60px;" />
        </div>
        <h2 class="text-center">Welcomed, <span class="text-danger"><?= $currentUsername ?></span></h2>
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./assets/php/uploads/<?=$user['profile_pic']?>" alt="" height="30" class="rounded-circle border">
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?editProfile">Edit Profile</a></li>
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
            </li>
        </ul>
    </div>
</nav>
