<?php
require('comm_php/db_con.php');
require('comm_php/sec_head.php');

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Start session
session_start();

// Check if user is not logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

//get password form html
$user_id = $_SESSION['user_id'];

$stmt = $conn -> prepare("SELECT PID FROM persons WHERE PID = ?;");
$stmt -> bind_param("s", $user_id);
$stmt -> execute();
$result = $stmt -> get_result();
if ($result -> num_rows == 1){
    $row = $result -> fetch_assoc();
    $db_id = $row['PID'];
    $stmt->close();

    $mSalt = bin2hex(random_bytes(32)); 
    $ePIV = bin2hex(random_bytes(64)); 

    $mpassword = hash('sha512',$mSalt.$_POST['password']);

    //stmp for update mSalt
    $stmt = $conn -> prepare("UPDATE emailsalt SET MSalt = ?, EPIV = ? WHERE PID = ?;");
    $stmt -> bind_param("sss", $mSalt,$PIVe, $db_id);
    $stmt -> execute();
    $stmt->close();
    //stmp for update mpassword
    $stmt = $conn -> prepare("UPDATE persons SET MPassword = ?, Mcheck = 1 WHERE PID = ?;");
    $stmt -> bind_param("ss", $mpassword, $db_id);
    $stmt -> execute();
    $stmt->close();
}

}

else {
    header('Location: dashboard.php');
    exit();

}









?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SecPass - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/x-icon" href="SecPass.png">
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            
        <span class="navbar-toggler-icon"></span>
      </button> 
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="masterpass.php">Master Key</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Files</a>
                    </li>
                </ul>

            </div>
            <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="user.php"><?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                      <form action="comm_php/logout.php"  method="POST" >
                          <button type="submit" class="btn btn-danger"> Logout </button>
                      </form>
                       
                    </li>
                </ul>
        </div>
        
    </nav>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <link rel="icon" type="image/x-icon" href="SecPass.png">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Master Password</h4>
                        <form id="masterPasswordForm" method="POST" action="masterpass.php">
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="password" class="form-control" id="passwordInput" name="password" required>
                                <div class="form-text" id="passwordStrengthMeter"></div>
                                <ul id="passwordFeedbackList" class="mt-2"></ul>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPasswordInput" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPasswordInput" required>
                                <div id="confirmPasswordFeedback" class="form-text"></div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="confirmButton" class="btn btn-danger" disabled>Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>>
    <script src="js/masterpass.js "></script>

</body>

</html>