<?php
mysqli_report(MYSQLI_REPORT_OFF);

$tests = [
    ['localhost', 'root', ''],
    ['127.0.0.1', 'root', ''],
    ['localhost', 'root', 'root'],
    ['127.0.0.1', 'root', 'root'],
    ['localhost', 'root', 'admin'],
    ['127.0.0.1', 'root', 'admin'],
    ['localhost', 'root', '123456'],
    ['127.0.0.1', 'root', '123456'],
    ['localhost', 'root', 'password'],
    ['127.0.0.1', 'root', 'password'],
];

foreach ($tests as $t) {
    $conn = @new mysqli($t[0], $t[1], $t[2]);
    if (!$conn->connect_error) {
        echo "SUCCESS: host={$t[0]}, user={$t[1]}, pass='{$t[2]}'\n";
        exit(0);
    } else {
        echo "FAILED: host={$t[0]}, pass='{$t[2]}': " . $conn->connect_error . "\n";
    }
}
?>
