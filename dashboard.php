<?php
require('comm_php/db_con.php');
require('comm_php/sec_head.php');

// Start session
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
                        <a class="nav-link active" aria-current="page" href="#">Master Key</a>
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

    <!-- Main Content -->
    <div class="container my-5">
      <h1>Dashboard</h1>
      <p>Welcome to your dashboard. Here, you can view your account information, analytics, and more.</p>
      <div class="row my-5">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Analytics</h5>
              <p class="card-text">View your website's analytics, including page views, unique visitors, and more.</p>
              <a href="#" class="btn btn-primary">View Analytics</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Account Information</h5>
              <p class="card-text">View and edit your account information, including your name, email, and password.</p>
              <a href="#" class="btn btn-primary">View Account Information</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    Here's an example script tag that you can use to include the jQuery library in your HTML file:

php
Copy code
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Optional JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>

  </body>
</html>