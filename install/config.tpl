<?php
$host     = "<DB_HOST>"; // Database Host
$user     = "<DB_USER>"; // Database Username
$password = "<DB_PASSWORD>"; // Database's user Password
$database = "<DB_NAME>"; // Database Name

$mysqli = new mysqli($host, $user, $password, $database);

// Checking Connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$mysqli->set_charset("utf8mb4");

// Settings
include "config_settings.php";
?>