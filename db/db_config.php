<?php
try {
    
$username = "root";
$password = "";
$connection = new PDO("mysql:host=localhost;dbname=mybook",$username,$password);
}catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>