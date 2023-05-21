<?php
$url = "www.boc.lk"; // the URL to get the logo for
echo json_encode(array("url" => $url)); // send the URL to the frontend as JSON

require("../comm_php/db_con.php");

// Start session
session_start();
//Session ID
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT p.Mpassword, e.MSalt, e.EPIV FROM persons p, emailsalt e WHERE p.PID = ? AND e.PID = ?");
$stmt->bind_param("ss", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $masterpass = $row['Mpassword'];
    $masterSalt = $row['MSalt'];
    $iVector = bin2hex(random_bytes(8));
    $iVectorLength = strlen($iVector); // Get the byte length of $iVector

    $stmt->close();
    echo $iVector;
    echo "\nBytes of is :  ".$iVectorLength."bytes";
    // Rest of your code...
}




?>

<!DOCTYPE html>
<html>
  <head>
    <title>Website Logo Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h1 class="my-4">Website Logo Example</h1>
      <div class="row">
        <div class="col-8">
          <input type="text" id="urlInput" class="form-control mb-2" placeholder="<?php echo $url ?>">
        </div>
        <div class="col-4">
          <button class="btn btn-primary mb-2" onclick="getLogo()">Get Logo</button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <img id="logoImg" src="" alt="" height="24px" width="24px">
        </div>
      </div>
    </div>
    
    <script>
        var apiUrl = 'https://logo.clearbit.com/' + '<?php echo $url ?>';
        console.log(apiUrl);
        document.getElementById('logoImg').src = apiUrl;
     
    </script>
  </body>
</html>


