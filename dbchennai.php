<?php
$servername = "####";
$dbusername = "####";
$dbpassword = "####";
$dbname = "####";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
