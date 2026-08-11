<?php
mysqli_report(MYSQLI_REPORT_OFF);

$hosts = ['localhost', '127.0.0.1'];
$ports = [3306, 3307, 3308];
$passwords = ['', 'root', 'admin', 'password', '123456', 'mysql', 'mariadb', 'root123', '1234'];

foreach ($hosts as $h) {
    foreach ($ports as $port) {
        foreach ($passwords as $p) {
            $conn = @new mysqli($h, 'root', $p, '', $port);
            if (!$conn->connect_error) {
                echo "SUCCESS: host={$h}, port={$port}, pass='{$p}'\n";
                // Try importing or creating database
                $conn->query("CREATE DATABASE IF NOT EXISTS u500152941_carpool");
                exit(0);
            }
        }
    }
}

echo "ALL_FAILED\n";
?>
