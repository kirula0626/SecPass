<?php
session_start();

// Check if user is not logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// else{
//   header('Location : dashboard.php');
// }

// Generate session token

//echo $_SESSION['token'] ;

// Disable caching of this page
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecPass - User Page</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" />
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
                        <a class="nav-link active" aria-current="page" href="#">Master Key</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Files</a>
                    </li>
                </ul>

            </div>
            <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link  active" href="user.php">User : <?php echo $_SESSION['username']; ?>    </a>
                    </li>
                    <li class="nav-item">
                      <form action="comm_php/logout.php"  method="POST" >
                          <button type="submit" class="btn btn-danger"> Logout </button>
                      </form>
                       
                    </li>
                </ul>
        </div>
        
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <h1>Secure Password Manager</h1>
        <p class="lead">This is where you can store and access your Usernames and Passwords!</p>

        <form method="POST" action="masterpass.php">
        <lable><h3><a href="masterpass.php">Change Master Key</a></h></label>
        </form>
        
    </div>

    <!-- Bootstrap 5 JS and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js"></script>
</body>

</html>