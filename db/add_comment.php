<?php
session_start();
require_once("./db_config.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "You must be logged in."]);
    exit;
}

if (empty($_POST['post_id']) || empty($_POST['comment'])) {
    echo json_encode(["error" => "Missing data."]);
    exit;
}

$post_id = intval($_POST['post_id']);
$user_id = $_SESSION['user_id'];
$comment = trim($_POST['comment']);

// Insert comment
$stmt = $connection->prepare("INSERT INTO comments (post_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
$stmt->execute([$post_id, $user_id, $comment]);

// Get commenter name
$user = $connection->prepare("SELECT name FROM users WHERE id = ?");
$user->execute([$user_id]);
$name = $user->fetchColumn();

echo json_encode([
    "name" => $name,
    "comment" => htmlspecialchars($comment),
    "created_at" => date("Y-m-d H:i:s")
]);
