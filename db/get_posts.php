<?php 

include("db_config.php");


$sql = "SELECT posts.*, users.name FROM posts 
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$result = $connection->query($sql);
// echo $connection->error;
// if(!$result){
//     die("Query failed: " . $result->error);
// }
?>