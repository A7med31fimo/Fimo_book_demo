<?php 
include './db_config.php';
if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $post_id);
    if ($stmt->execute()) {
        header("Location: ../index.php?message=Post+deleted+successfully");
        exit();
    } else {
        echo "Error deleting post: " . $conn->error;
    }
    $stmt->close();
}

?>