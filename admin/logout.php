<?php
/**
 * Admin Logout Handler
 * Folder Location: admin/logout.php
 */

require_once 'includes/session.php';

// Unset all session variables
$_SESSION = array();

// Destroy session cookie if present
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Start a fresh session to set flash logout message
session_start();
set_flash_message('info', 'You have been logged out successfully.');

// Redirect to login page
header("Location: login.php");
exit();
?>
