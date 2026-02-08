<?php
$conn = mysqli_connect("localhost","root","","canteen_db");
if(!$conn){
    die("Database connection failed");
}
session_start();
?>
