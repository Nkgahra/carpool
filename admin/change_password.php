<?php

require_once "include/db.php";
require_once "include/session_check.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    $id = $_SESSION['admin_id'];

    
    $query = "SELECT * FROM admins WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $admin = mysqli_fetch_assoc($result);

        
        if (!password_verify($current, $admin['password'])) {

            $error = "Current password is incorrect.";

        }

        
        elseif ($new != $confirm) {

            $error = "New passwords do not match.";

        }

        
        elseif ($current == $new) {

            $error = "New password must be different from the current password.";

        }

      
        elseif (strlen($new) < 6) {

            $error = "Password must be at least 6 characters long.";

        }

        
        else {

            $hashedPassword = password_hash($new, PASSWORD_DEFAULT);

            $update = "UPDATE admins SET password='$hashedPassword' WHERE id='$id'";

            if (mysqli_query($conn, $update)) {

                $message = "Password changed successfully!";

            } else {

                $error = "Something went wrong. Please try again.";

            }

        }

    } else {

        $error = "Admin account not found.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <h1>Change Password</h1>

        <?php
        if($error != ""){
            echo "<div class='error'>$error</div>";
        }

        if($message != ""){
            echo "<div class='success'>$message</div>";
        }
        ?>

        <form method="POST">

            <label>Current Password</label>

            <input
                type="password"
                name="current_password"
                required>

            <label>New Password</label>

            <input
                type="password"
                name="new_password"
                required>

            <label>Confirm Password</label>

            <input
                type="password"
                name="confirm_password"
                required>

            <button type="submit">
                Change Password
            </button>

        </form>

        <br>

        <a href="dashboard.php">← Back to Dashboard</a>

    </div>

</div>

</body>
</html>