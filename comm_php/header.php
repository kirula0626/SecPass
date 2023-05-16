<?php session_start(); ?>

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