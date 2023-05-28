<?php
require('comm_php/sec_head.php');
require('comm_php/db_con.php');

// Start session
session_start();

       // Get the current year
       $currentYear = date('Y');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $stmt = $conn -> prepare("SELECT PID FROM persons ORDER BY PID DESC LIMIT 1");
        $stmt -> execute();
        $result = $stmt -> get_result();

        if($result -> num_rows == 1 ){
            $row = $result -> fetch_assoc();
            $db_id = $row['PID'];
           

            // Extract the year and index from secP20231
            $year = substr($db_id , 4, 4);
            $index = intval(substr($db_id , 8));
   
            // If the year is not the current year, update it to the current year
            if ($year != $currentYear) {
                $year = $currentYear;
                $index += 1;
             } else {
                $index += 1;
            }
   
               // Combine the components and typecast to a string
               $new_db_id = 'secP' . $year . strval($index);
        }
        
        elseif ($result->num_rows == 0) {
            $new_db_id = 'secP' . $currentYear . '1';
        }
        else{
            echo '<script>console.log("Check Persons")</script>';
        }
        $stmt ->close();
    

        // Get username/email and password from form
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = "";
        $birthday = $_POST['dob'];
        $telephone = $_POST['country-code']. $_POST['phone'];

        //Make salt value of Register Password
        $salt = bin2hex(random_bytes(16));

        //make Hash value password 
        $password = hash('sha256',$salt.$_POST['password']);

        //Insert values into persons
        $stmt = $conn -> prepare("INSERT INTO persons(PID, PUsername, PEmail,PPassword, PDOB, PPhoneNo) VALUES (?,?,?,?,?,?)");
        $stmt -> bind_param("ssssss", $new_db_id, $username, $email, $password, $birthday, $telephone);
        $stmt -> execute();
        $stmt ->close();

        //Get emailsalt SID and increment by one
        $stmt = $conn -> prepare("SELECT SID FROM emailsalt ORDER BY SID DESC LIMIT 1");
        $stmt -> execute();
        $result = $stmt -> get_result();

        if($result -> num_rows == 1 ){
            $row = $result -> fetch_assoc();
            $salt_db_id = $row['SID'];

            $index = intval(substr($salt_db_id,5));
            $index += 1;
            $salt_db_id = 'saltP'.strval($index);
        }
        elseif ($result -> num_rows == 0){
            $salt_db_id = 'saltP1';
        }
        else{
            echo '<script>console.log("Check Emailsalt")</script>';
        }
        $stmt ->close();

        
        
        //Insert values into emailsalt
        $stmt = $conn -> prepare("INSERT INTO emailsalt (SID, PID, PSalt) VALUES (?,?,?)");
        $stmt -> bind_param("sss", $salt_db_id, $new_db_id, $salt);
        $stmt -> execute();
        $stmt ->close();



        $conn->close();//close db connection

    }



?>

<!DOCTYPE html>
<html>

<head>
    <title>SecPass - Register</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <link rel="icon" type="image/x-icon" href="SecPass.png">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4">User Registration Form</h2>
                <form id="user-registration-form" method="POST" action="register.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                        <span class="error-message" id="username-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <span class="error-message" id="email-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8">
                        <span class="error-message" id="password-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                        <span class="error-message" id="confirm-password-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                        <span class="error-message" id="dob-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="country-code" class="form-label">Country Code</label>
                        <!-- Replace "COUNTRY CODES" with the list of all country codes obtained from a web source -->
                        <select class="form-select" id="country-code" name="country-code">
							<option value="">-- Select Country Code --</option>
							<option value="+91">+91</option>
							<option value="+1">+1</option>
							<option value="+44">+44</option>
						</select>
                        <span class="error-message" id="country-code-error"></span>
                    </div>
                    <div class=" mb-3 ">
                        <label for="phone " class="form-label ">Phone Number</label>
                        <input type="tel " class="form-control " id="phone " name="phone">
                        <span class="error-message " id="phone-error "></span>
                    </div>
                    <button type="submit " class="btn btn-primary ">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js "></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
    <script src="js/register.js "></script>
    </body>
    </html>