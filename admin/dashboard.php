<?php
require_once "include/session_check.php";
require_once "include/db.php";

/* Dashboard Counts */

$admins = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM admins"));

$cities = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM cities"));

$banners = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM banners"));

$notifications = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM notifications"));
?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard</title>

<link rel="stylesheet" href="assets/css/dashboard.css">

</head>

<body>

<div class="sidebar">

<h2> Carpool</h2>

<a href="#">Dashboard</a>

<a href="#">Admins</a>

<a href="#">Cities</a>

<a href="#">Banners</a>

<a href="#">Notifications</a>

<a href="change_password.php">Change Password</a>

<a href="logout.php">Logout</a>

</div>

<div class="main">

<h1>Welcome, <?php echo $_SESSION['admin_name']; ?></h1>

<div class="cards">

<div class="card">

<h2><?php echo $admins; ?></h2>

<p>Admins</p>

</div>

<div class="card">

<h2><?php echo $cities; ?></h2>

<p>Cities</p>

</div>

<div class="card">

<h2><?php echo $banners; ?></h2>

<p>Banners</p>

</div>

<div class="card">

<h2><?php echo $notifications; ?></h2>

<p>Notifications</p>

</div>

</div>

</div>

</body>

</html>