<?php

// Database Configuration
$dbHost = "localhost";
$dbName = "carpool_db";
$dbUser = "root";
$dbPass = "";

// Create Database Connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set Character Encoding
$conn->set_charset("utf8mb4");

// Set Default Timezone
date_default_timezone_set("Asia/Kolkata");