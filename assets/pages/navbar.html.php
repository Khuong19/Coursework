<?php

if (isset($_SESSION['user'])) {
    // Access user data
    $user = $_SESSION['user'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../../?login");
    exit();
}

// Check if the logout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {

    // Unset the user session variable
    session_destroy();
    
}
?>

<nav class="navbar navbar-expand-lg">
    <div class="container d-flex justify-content-between">
        <div class="d-flex justify-content-between col-8">
            <form class="d-flex w-100" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>



        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link text-dark" href="?"><i class="bi bi-house-door-fill"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark"  href="?addpost"><i class="bi bi-plus-square-fill"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="?sendmail"><i class="bi bi-envelope-arrow-up-fill"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="asssets/php/uploads/<?=$user['profile_pic']?>" alt="" height="30" class="rounded-circle border">
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?editProfile">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="?editmodule">Edit Module</a></li>
                    <li><a class="dropdown-item" href="?posts">Posts</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="nav-item">
                        <!-- Use a form to submit the logout request -->
                        <form method='post'>
                            <button type="submit" name="logout" class="btn nav-link text-dark">
                                <a href="?login">Log out</a>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
