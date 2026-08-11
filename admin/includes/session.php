<?php
/**
 * Session & Authentication Management Header
 * Folder Location: admin/includes/session.php
 */

// Start session & output buffering if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (ob_get_level() === 0) {
    ob_start();
}

/**
 * Check if the admin is logged in.
 * If not logged in, redirect immediately to the login page.
 */
function check_admin_login() {
    if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
        $_SESSION['flash_error'] = "Please log in to access the Admin Panel.";
        $login_url = file_exists('login.php') ? 'login.php' : '../login.php';
        header("Location: " . $login_url);
        exit();
    }
}

/**
 * Helper function to check login status without redirecting.
 * 
 * @return bool True if logged in, false otherwise.
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Set a flash notification message (Success / Error / Warning / Info)
 */
function set_flash_message($type, $message) {
    $_SESSION['flash_type'] = $type; // e.g., 'success', 'danger', 'warning', 'info'
    $_SESSION['flash_message'] = $message;
}

/**
 * Display and clear session flash message
 */
function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        $message = htmlspecialchars($_SESSION['flash_message']);
        
        echo "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";

        // Clear after displaying
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
    }
}
?>
