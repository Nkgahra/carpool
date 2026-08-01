<?php
session_start();

require_once "include/db.php";

$error = "";
if(isset($_GET['timeout'])){
    $error = "Session expired. Please login again.";
}
$remember_email = "";

if (isset($_COOKIE['remember_email'])) {
    $remember_email = $_COOKIE['remember_email'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM admins WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {

           $_SESSION['admin_id'] = $admin['id'];
           $_SESSION['admin_name'] = $admin['name'];
           $_SESSION['admin_email'] = $admin['email'];
           $_SESSION['admin_role'] = $admin['role'];

           if(isset($_POST['remember'])){

            setcookie(
            "remember_email",
            $email,
            time() + (30 * 24 * 60 * 60),
            "/"
            );

          }else{


            setcookie(
            "remember_email",
            "",
            time() - 3600,
            "/"
            );

          }

           header("Location: dashboard.php");
           exit();

        } else {

            $error = "Wrong Password!";

        }

    } else {

        $error = "Email Not Found!";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>
<body>


<div class="login-container">

    <div class="login-card">

        <h1> Carpool Admin</h1>

        <p class="subtitle">
            Sign in to continue
        </p>

        <?php
        if ($error != "") {
            echo "<div class='error'>$error</div>";
        }
        ?>

        <form action="" method="POST">

            <label>Email</label>

            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($remember_email); ?>"
                placeholder="Enter your email"
                required>

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required>

            <div class="options">

                <label class="remember">
                    <input
                        type="checkbox"
                        name="remember"
                        <?php
                        if(isset($_COOKIE['remember_email'])){
                            echo "checked";
        
                        }
                        ?>
                    >
                    Remember Me
                </label>

                <a href="forgot_password.php">Forgot Password?</a>
            </div>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>


</body>
</html>