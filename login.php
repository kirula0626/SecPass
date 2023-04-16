<?php
    require('comm_php/sec_head.php');
    require('comm_php/db_con.php');

    // Start session
    session_start();
    
    

    // Check if form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Get username/email and password from form
            $username = $_POST['username'];
            $password = $_POST['password'];

            echo "<script>alert('$password')</script>";

            // Check if username or email exists in database
            $stmt = $conn -> prepare("SELECT PPassword,PID FROM persons WHERE PUsername = ? OR PEmail = ?");
            $stmt -> bind_param("ss", $username, $username);
            $stmt -> execute();
            $result = $stmt -> get_result();

            if($result -> num_rows == 1 ){
                // Get password from database
                $row = $result -> fetch_assoc();
                $db_password = $row['PPassword'];
                $db_id = $row['PID'];
                echo "<script>alert('$db_password')</script>";

                // Check if password is correct
                if(!password_verify($password, $db_password)){
                    $_SESSION['user_id'] = $db_id;
                    $_SESSION['username'] = $username;
                    // Password is correct
                    // Check if remember me is checked
                    if(isset($_POST['rememberMe'])){
                        // Remember me is checked
                        // Set cookie for 1 year
                        setcookie('username', $username, time() + (86400 * 365), "/", "", true, true); // HttpOnly attribute added
                        setcookie('password', $password, time() + (86400 * 365), "/", "", true, true); // HttpOnly attribute added
                    } else {
                        // Remember me is not checked
                        // Set cookie for 1 hour
                        setcookie('username', $username, time() + 3600, "/", "", true, true); // HttpOnly attribute added
                        setcookie('password', $password, time() + 3600, "/", "", true, true); // HttpOnly attribute added
                    }

                    // Redirect to home page
                    header("Location: dashboard.php");
                } else {
                    // Password is incorrect
                 $error = "<div class='alert alert-danger'>Incorrect  password</div>";
                }
            } else {
                // Username or email does not exist
                $error = "<div class='alert alert-danger'>Incorrect username or password</div>";
            }

        }
        
    
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Login</h4>
                        <form id="loginForm" method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="usernameInput" class="form-label">Username or Email</label>
                                <input type="text" class="form-control" id="usernameInput" name="username" required />
                            </div>
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="password" class="form-control" id="passwordInput" name="password" required />
                                <div class="invalid-feedback">Password must be at least 8 characters long</div>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="rememberMeInput" name="rememberMe" />
                                <label class="form-check-label" for="rememberMeInput">Remember me</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <?php if(isset($error)) echo $error; ?>
                            </div>
                            <div class="text-center mt-3">
                                <a href="forgetpass.html" target="_self">Forgot password?</a>
                            </div>
                            <br>
                            <div>
                                <label class="form-label">Need an account ? <a href="register.html">Signup</a></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>