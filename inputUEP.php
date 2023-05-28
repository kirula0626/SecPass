<?php
require('comm_php/sec_head.php');
require('comm_php/db_con.php');
require('comm_php/encryp_decryp.php');

$currentYear = date('Y');
// Start session
session_start();

$user_id = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  //get input values

  $websiteUrl = $_POST['websiteUrlInput'];
 // Extract the host
  $host = parse_url($websiteUrl, PHP_URL_HOST);
  // Split the host on '.' to get the parts
  $parts = explode('.', $host);
  // If the host begins with 'www', remove it
  if ($parts[0] == 'www') {
    array_shift($parts);
  }
  // Join the remaining parts back together
  $domain = implode('.', $parts);

  $email = $_POST['emailInput'];
  $password = $_POST['passwordInput'];
 // $masterPassword = $_POST['masterPasswordInput'];

  //check if master password is correct
  $stmt = $conn -> prepare("SELECT p.Mpassword,e.MSalt,e.EPIV FROM persons p,emailsalt e WHERE p.PID = ? AND e.PID = ?;");
  $stmt -> bind_param("ss", $user_id,$user_id);
  $stmt -> execute();
  $result = $stmt -> get_result();
  if ($result -> num_rows == 1){
    $row = $result -> fetch_assoc();
    $masterpass = $row['Mpassword'];
    $masterSalt = $row['MSalt'];
    $iVector = $row['EPIV'];
    $stmt->close();

    $inputMasterPassword = hash('sha512',$masterSalt.$_POST['masterPasswordInput']); // Input MasterPassword --> Hash MasterPassword

    //check input password is correct
    if($inputMasterPassword === $masterpass){
        //Get EPID last for table 
        $stmt = $conn -> prepare("SELECT EPID FROM emailpass ORDER BY EPID DESC LIMIT 1");
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows == 1 ){
            $row = $result -> fetch_assoc();
            $epid = $row['EPID'];
            $stmt->close();
            // Extract the year and index from EP20231  
            $year = substr($epid , 2, 4);
            $index = intval(substr($epid , 6));
            // If the year is not the current year, update it to the current year
            if ($year != $currentYear) {
                $year = $currentYear;
                $index += 1;
            } else {
                $index += 1;
            }
            // Combine the components and typecast to a string
            $epid = 'EP' . $year . strval($index);

        } elseif($result -> num_rows == 0){
            
            $epid = 'EP'. $currentYear.'1';
        } else{
            echo "<script>console.log('Check Email Pass ID')</script>";
        }
        //Password Encrypt AES
        $encrptPass =  encryptData($password,$masterpass,$iVector);
        //Insert values to emailpass table
        $stmt = $conn -> prepare("INSERT INTO emailpass (EPID, PID, SITE, URL,Email,Password) VALUES (?,?,?,?,?,?);");
        $stmt -> bind_param("ssssss",$epid, $user_id, $domain, $websiteUrl, $email, $encrptPass);
        $stmt -> execute();
        $stmt->close();
        echo '<script>window.alert("Recorde Instered Sucessfull")</script>';
      
        }
  }
  else{
      echo "<script>window.alert('Master Password is incorrect')</script>";
     // header('Location: dashboard.php');
  }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

  <style>
    #logoImg {
      border-radius: 50%;
    }
    .hidden {
      display: none;
    }
  </style>

</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-6 text-center">
        <img src="" id="logoImg" alt="Logo" class="mb-4">
        <h3>Website Login</h3>
      </div>
    </div>
    <form id="loginForm" method="POST" action="inputUEP.php" >
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="websiteUrlInput" class="form-label">Website URL:</label>
            <input type="url" class="form-control" id="websiteUrlInput" name="websiteUrlInput" placeholder="https://www.google.com" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="emailInput" class="form-label">Username or Email:</label>
            <input type="text" class="form-control" id="emailInput" name="emailInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="mb-3">
            <label for="passwordInput" class="form-label">Password:</label>
            <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
          </div>
        </div>
      </div>
      <div class="row justify-content-center" id="masterPasswordRow">
      <div class="col-6">
        <div class="mb-3">
          <label for="masterPasswordInput" class="form-label">Master Password:</label>
          <input type="password" class="form-control" id="masterPasswordInput" name="masterPasswordInput" required>
        </div>
      </div>
    </div>
      <div class="row justify-content-center">
        <div class="col-6">
          <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
        </div>
      </div>
    </form>
  </div>

  <script>
 
    document.getElementById('websiteUrlInput').addEventListener('input', function() {
      var url = this.value;
      var apiUrl = 'https://logo.clearbit.com/' + url;
      document.getElementById('logoImg').src = apiUrl;
    });
</script>

</body>
</html>
