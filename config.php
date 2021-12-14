<?php 
session_start();
$server = "localhost";
$user = "root";
$pass = "usbw";
$database = "task_manager";

$conn = mysqli_connect($server, $user, $pass, $database);
$conn->set_charset('utf8');

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>