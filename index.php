<?php
/**
 * Root Entry Point - Car & Bike Pool Application
 * Folder Location: index.php
 */

require_once 'admin/includes/session.php';

// Redirect to Admin Dashboard if logged in, otherwise to Admin Login
if (is_admin_logged_in()) {
    header("Location: admin/dashboard.php");
    exit();
} else {
    header("Location: admin/login.php");
    exit();
}
?>
