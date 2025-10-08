<?php 
include './db_config.php';
if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$post_id]);
    if ($stmt->rowCount() > 0 ) {
        header("Location: ../index.php?message= deleted successfully");
        exit();
    } else {
        echo "Error deleting post: " . $conn->error;
    }
}else {
    echo "Invalid delete.";
}
?>