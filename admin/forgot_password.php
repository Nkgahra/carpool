<?php
session_start();

require_once "include/db.php";

$error = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");

    if(mysqli_num_rows($check) == 0){

        $error = "Email not found.";

    }elseif($new != $confirm){

        $error = "Passwords do not match.";

    }else{

        $hashedPassword = password_hash($new, PASSWORD_DEFAULT);

        $update = "UPDATE admins SET password='$hashedPassword' WHERE email='$email'";

        if(mysqli_query($conn, $update)){

           $message = "Password updated successfully.";

        }else{

           $error = "Failed to update password.";
    
        }

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forgot Password</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="login-container">

<div class="login-card">

<h1>Forgot Password</h1>

<p class="subtitle">Reset your password</p>

<?php

if($error!=""){
echo "<div class='error'>$error</div>";
}

if($message!=""){
echo "<div class='success'>$message</div>";
}

?>

<form method="POST">

<label>Email</label>

<input type="email"
name="email"
required>

<label>New Password</label>

<input type="password"
name="new_password"
required>

<label>Confirm Password</label>

<input type="password"
name="confirm_password"
required>

<button type="submit">

Reset Password

</button>

</form>

<br>

<a href="login.php">

← Back to Login

</a>

</div>

</div>

</body>

</html>