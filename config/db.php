<?php
$conn = mysqli_connect("localhost","root","","23cs022");
if(!$conn){
    die("Database connection failed");
}
session_start();
?>
