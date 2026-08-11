<?php
/**
 * Database Connection File
 * Technology: Core PHP with MySQLi
 * Database: u500152941_carpool
 */

// Disable mysqli exception reporting globally before any connection attempts
mysqli_report(MYSQLI_REPORT_OFF);

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'u500152941_carpool');

function die_with_db_error($error_msg) {
    die("<div style='font-family: Segoe UI, Arial, sans-serif; padding: 30px; background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; margin: 50px auto; max-width: 650px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
            <h2 style='margin-top:0;'>⚠️ Database Connection Required</h2>
            <p>Could not connect to MySQL database <strong>" . DB_NAME . "</strong>.</p>
            <p style='background: #fff; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 14px;'><strong>MySQL Error:</strong> " . htmlspecialchars($error_msg) . "</p>
            <hr style='border: 0; border-top: 1px solid #feb2b2; margin: 20px 0;'>
            <p><strong>How to fix:</strong></p>
            <ol style='line-height: 1.6;'>
                <li>Open <strong>XAMPP Control Panel</strong> and click <strong>Start</strong> next to MySQL.</li>
                <li>Import <code>schema.sql</code> or <code>u500152941_carpool (5) (1).sql</code> into <strong>phpMyAdmin</strong> (<code>http://localhost/phpmyadmin</code>).</li>
                <li>If your MySQL root user has a password set in XAMPP, update <code>DB_PASS</code> in <code>config/database.php</code>.</li>
            </ol>
         </div>");
}

// Attempt connection using default settings, then fallbacks if needed
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    $fallback_credentials = [
        ['localhost', 'root', ''],
        ['127.0.0.1', 'root', ''],
        ['localhost', 'user1', '1234'],
        ['127.0.0.1', 'user1', '1234'],
        ['localhost', 'root', 'root'],
    ];

    foreach ($fallback_credentials as $cred) {
        $test_conn = @new mysqli($cred[0], $cred[1], $cred[2], DB_NAME);
        if (!$test_conn->connect_error) {
            $conn = $test_conn;
            break;
        }
    }
}

if ($conn->connect_error) {
    die_with_db_error($conn->connect_error);
}

// Set character set to utf8mb4 for proper character encoding
$conn->set_charset("utf8mb4");
?>
