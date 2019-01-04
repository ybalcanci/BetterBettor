<?php
$pass = "<PASSWORD>";
$servername = "<SERVER_URL>";
$username = "<USERNAME_TO_CONNECT_TO_THE_SERVER>";
$db = "<DATABASE_NAME>";
session_start();
$conn = mysqli_connect($servername, $username, $pass, $db);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
?>
