<?php

require('../comm_php/sec_head.php');
require('../comm_php/db_con.php');
require('../comm_php/encryp_decryp.php');
// Start session
session_start();

//session ID
$user_id = $_SESSION['user_id'];

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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmailPass List</title>
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
    <div class="container">
        <div class="table-container">
            <h1>EmailPass List</h1>
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