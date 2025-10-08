<?php 

require "db_config.php" ;


$sql = "SELECT posts.*, users.name FROM posts 
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$result = $connection->query($sql);
$posts = $result->fetchAll(PDO::FETCH_ASSOC);
// var_dump($posts);       
// var_dump($result);
// echo $connection->error;
// if(!$result){
//     die("Query failed: " . $result->error);
// }
?>