<?php
require_once 'config/database.php';
header('Content-Type: text/plain');

echo "Database Connection Successful!\n";
echo "Host: " . DB_HOST . "\n";
echo "Database: " . DB_NAME . "\n\n";

$res = $conn->query("SHOW TABLES");
echo "Tables in database:\n";
while ($row = $res->fetch_array()) {
    echo "- " . $row[0] . "\n";
}
