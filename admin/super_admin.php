<?php


require_once "include/session_check.php";

if ($_SESSION['admin_role'] != "Super Admin") {
    die("Access Denied");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Super Admin Panel</title>
</head>
<body>

<h1>Welcome Super Admin!</h1>

<p>Only Super Admin can access this page.</p>

</body>
</html>