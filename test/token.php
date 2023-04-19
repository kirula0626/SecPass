<?php
session_start();

// Generate session token
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(16));
}

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify session token
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die('Invalid form submission');
    }
    
    setcookie('token', session_id(), time() + (86400 * 365), "/", "", true, true);
    // Process form data
    // ...
}

?>

<form method="post">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="text" name="username">
    <input type="password" name="password">
    <button type="submit">Submit</button>
</form>
