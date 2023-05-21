<?php
    require('comm_php/sec_head.php');
    require('comm_php/db_con.php');

    // Start session
    session_start();
    
    //if session has user_id user can't come to loging.php. redirect to dashboard.php


    if(isset($_SESSION['user_id'])) {
        header('Location: dashboard.php');
        exit;
    }

    // Check if form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Get username/email and password from form
            $username = $_POST['username'];
            $password = $_POST['password'];
            echo "<script>console.log('$username')</script>";
            // Check if username or email exists in database
            $stmt = $conn -> prepare("SELECT PID FROM persons p WHERE PUsername = ? OR PEmail = ?");
            $stmt -> bind_param("ss", $username, $username);
            $stmt -> execute();
            $result = $stmt -> get_result();
           // $stmt->close();

            if($result -> num_rows == 1 ){
                
                $row = $result -> fetch_assoc();
                $db_id = $row['PID'];
                echo "<script>console.log('$db_id')</script>";
                $stmt->close();

                //// Get password from database
                $stmt = $conn -> prepare("SELECT p.PPassword, e.PSalt FROM persons p, emailsalt e WHERE p.PID = ? AND e.PID = ?");
                $stmt -> bind_param("ss", $db_id, $db_id);
                $stmt -> execute();
                $result = $stmt -> get_result();

                if($result -> num_rows == 1 ){
                    $row = $result -> fetch_assoc();
                    $db_password = $row['PPassword'];
                    $db_salt = $row['PSalt'];

                    $password = hash('sha256',$db_salt.$password);
                    echo "<script>console.log('$password')</script>";
                    // Check if password is correct
                    if($password === $db_password){
                        $_SESSION['user_id'] = $db_id;
                        $_SESSION['username'] = $username;
                       // $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate session token

                        
                        // Password is correct
                        // Check if remember me is checked
                        if(isset($_POST['rememberMe'])){
                            // Remember me is checked
                            // Set cookie for 1 year
                            setcookie('username', $username, time() + (86400 * 365), "/", "", true, true); // HttpOnly attribute added
                            //setcookie('password', $password, time() + (86400 * 365), "/", "", true, true); // HttpOnly attribute added
                        } else {
                            // Remember me is not checked
                            // Set cookie for 1 hour
                            setcookie('username', $username, time() + 3600, "/", "", true, true); // HttpOnly attribute added
                            //setcookie('password', $password, time() + 3600, "/", "", true, true); // HttpOnly attribute added
                        }

                        // Redirect to home page
                      header("Location: dashboard.php");
                    } else {
                        // Password is incorrect
                        $error = "<div class='alert alert-danger'>Incorrect  password</div>";
                    }
                }
                
            }else {
                // Username or email does not exist
                $error = "<div class='alert alert-danger'>Incorrect username or password</div>";
            }
        $stmt ->close();
        $conn ->close();
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <title>SecPass - Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="icon" type="image/x-icon" href="SecPass.png">

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
                                <br>
                                <?php if(isset($error)) echo $error; ?>
                            </div>
                            <div class="text-center mt-3">
                                <a href="forgetpass.php" target="_self">Forgot password?</a>
                            </div>
                            <br>
                            <div>
                                <label class="form-label">Need an account ? <a href="register.php">Signup</a></label>
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