
<body>
        <div class="form-container my-5">
            <div class="form-box my-5">
                
                <?php
                // Display alert if signup error exists
                if (isset($_SESSION['signup_error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['signup_error'] . '</div>';
                    unset($_SESSION['signup_error']); // Clear the error after displaying it
                }
                ?>

                <form method="post" action="assets/php/signup.php" class="signup-form pt-0 text-dark">
                    <h2 class="hname text-center pt-4 pb-2 text-white ">Sign Up Form</h2>

                    <div class="form-floating mb-1">
                        <input type="text" name='username' class="form-control" id="floatingUName" placeholder="Username">
                        <label for="floatingUName">Username</label>
                    </div>

                    <div class="form-floating mb-1">
                        <input type="email" name='email' class="form-control" id="floatingInput" placeholder="Email">
                        <label for="floatingUName">Email address</label>
                    </div>
        
                    <div class="form-floating mb-1">
                        <input type="password" name='password' class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingUName">Password</label>
                    </div>

                    <div class="form-floating mb-1"><a class="" href="?login">Already has a account?</a></div>
                    <button type="submit" class="sub-btn w-100" value="add">Sign Up</button>
                </form>
            </div>
        </div>
</body>
