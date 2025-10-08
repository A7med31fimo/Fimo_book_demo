<?php
session_start();
require_once("./db_config.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in."]);
    exit;
}

if (!isset($_POST['post_id'])) {
    echo json_encode(["error" => "No post ID provided."]);
    exit;
}

$post_id = intval($_POST['post_id']);
$user_id = $_SESSION['user_id'];

// Check if liked
$check = $connection->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
$check->execute([$post_id, $user_id]);

if ($check->rowCount() > 0) {
    // Unlike
    $connection->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?")->execute([$post_id, $user_id]);
    $liked = false;
} else {
    // Like
    $connection->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)")->execute([$post_id, $user_id]);
    $liked = true;
}

// Count likes
$count = $connection->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
$count->execute([$post_id]);
$total = $count->fetchColumn();

echo json_encode([
    "liked" => $liked,
    "count" => $total
]);
