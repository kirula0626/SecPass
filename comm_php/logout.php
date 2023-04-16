<?php
require('sec_head.php');
// Start session
session_start();

// Unset session variables
session_unset();

// Destroy session
session_destroy();

// Disable caching of this page
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Redirect to login.php
header('Location: ../welcome.html');
exit();
?>
