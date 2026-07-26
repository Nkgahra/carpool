<?php

require_once 'config/config.php';
require_once 'config/constants.php';

echo "<h2>Configuration Test</h2>";

if ($conn) {
    echo "✅ Database Connected Successfully<br>";
}

echo "Application Name: " . APP_NAME . "<br>";
echo "Version: " . APP_VERSION . "<br>";
echo "Rows Per Page: " . ROWS_PER_PAGE . "<br>";
echo "Timezone: " . TIMEZONE . "<br>";

echo "<br><strong>Everything is working correctly.</strong>";