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
$user_id = $_SESSION['user_id'];

$stmt = $conn -> prepare("SELECT Mcheck FROM persons WHERE PID = ? ;");
$stmt -> bind_param("s", $_SESSION['user_id']);
$stmt -> execute();
$result = $stmt -> get_result();
if ($result -> num_rows == 1){
  $row = $result -> fetch_assoc();
  $Mcheck = $row['Mcheck'];
  $stmt->close();
  if($Mcheck == 0){
    
   header('Location: masterpass.php');
    
  }
}

// Retrieve data from emailpass table
$stmt = $conn->prepare("SELECT * FROM emailpass WHERE PID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows into an array
$rows = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Retrieve data from emailsalt table
$stmt = $conn->prepare("SELECT * FROM emailsalt WHERE PID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
// Fetch all rows into an array
$rows2 = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

//Retrieve data from persons table
$stmt = $conn->prepare("SELECT * FROM persons WHERE PID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
// Fetch all rows into an array
$rows3 = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();



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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .table-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .logo-img {
            width: 42px;
            height: 42px;
        }
        .reveal-password-btn {
            padding: 0.375rem 0.75rem;
        }
        .reveal-password-btn:focus {
            box-shadow: none;
        }
        .password {
            border: none;
            outline: none;
            background-color: transparent;
        }

    </style>
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
                        <a class="nav-link" href="inputUEP.php">New Recode</a>
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
    <div class="container">
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>EPID</th>
                        <th>Website</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>BTN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td>
                                <?php $url = $row['URL']; ?>
                                <a href="<?php echo $row['URL']; ?>" target="_blank" title="Click on">
                                <img src="https://logo.clearbit.com/<?php echo $url; ?>" alt="Logo" class="logo-img">
                                </a>
                            </td>
                            <td><a href="<?php echo $row['URL']; ?>" target="_blank"><?php echo $row['Site']; ?></a></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td>
                                <input type="password" value="Kirula123" readonly disabled>
                                <button class="btn btn-primary reveal-password-btn">Reveal</button>
                            </td>
                            <td>
                            
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Optional JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const revealButtons = document.querySelectorAll('.reveal-password-btn');
        const masterPassword = "Nanayakkara";

        revealButtons.forEach(button => {
        button.addEventListener('click', function () {
        const passwordInput = this.previousElementSibling;
        const isPasswordVisible = passwordInput.getAttribute('type') === 'text';

        if (isPasswordVisible) {
            passwordInput.setAttribute('type', 'password');
            this.textContent = 'Reveal';
        } else {
            const enteredMasterPassword = prompt('Enter Master Password:');
            if (enteredMasterPassword === masterPassword) {
                passwordInput.setAttribute('type', 'text');
                this.textContent = 'Hide';

                // Automatically hide the password after 5 seconds
                setTimeout(() => {
                    passwordInput.setAttribute('type', 'password');
                    this.textContent = 'Reveal';
                }, 5000);
            } else {
                alert('Incorrect Master Password');
            }
        }
    });
});
    </script>

  </body>
</html>