<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mybook";

$connection = mysqli_connect($host, $username, $password, $dbname);

if(!$connection){
    die("Database connection failed: " . mysqli_connect_error());
}else{
    // alert("Database connected successfully");
}
?>