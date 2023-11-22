    <body>
        <div class="form-container my-5">
            <div class="form-box my-5">
                <?php
                // Display alert if login error exists
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']); // Clear the error after displaying it
                }
                ?>
                <form class='login-form' method="post" action="assets/php/login.php" class="pt-0 text-dark">
                    <h2 class="hname text-center pt-4 pb-2 text-white">Login Form</h2>
    
                    <div class="form-floating mb-1">
                        <input type="text" name="username" class="form-control" id="floatingUName" placeholder="Username" required>
                        <label for="floatingUName">Username</label>
                    </div>
    
                    <div class="form-floating mb-1">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingUName">Password</label>
                    </div>
                    <div class='form-floating mb-1'>
                        <a href="?signup">Don't have an account?</a>
                    </div>
                    <button type="submit" class="sub-btn w-100" value="login">Login</button>
                </form>
            </div>
        </div>
    
    </body>
