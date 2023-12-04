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

                <div class="input-group mb-2">
                    <input type="text" name='username' class="form-control py-2" id="floatingUName" placeholder="Username">
                </div>

                <div class="input-group mb-2">
                    <input type="email" name='email' class="form-control" id="floatingInput" placeholder="Email">
                </div>

                <div class="input-group mb-2">
                    <input type="password" name='password' class="form-control" id="floatingPassword" placeholder="Password">
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordToggle">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="admin_status" id="adminRadio" value="1">
                    <label class="form-check-label" for="adminRadio">
                        Register as Admin
                    </label>
                </div>

                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="admin_status" id="userRadio" value="0" checked>
                    <label class="form-check-label" for="userRadio">
                        Register as User
                    </label>
                </div>

                <div class="form-floating mb-1"><a class="" href="?login">Already have an account?</a></div>
                <button type="submit" class="sub-btn w-100" value="add">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('showPasswordToggle').addEventListener('click', function () {
            var passwordInput = document.getElementById('floatingPassword');
            var icon = document.querySelector('#showPasswordToggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>
