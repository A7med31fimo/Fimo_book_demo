<?php
include("./db_config.php");

if (isset($_POST['btn_update'])) {
    $post_id = intval($_POST['post_id']);
    $content = mysqli_real_escape_string($connection, $_POST['content']);

    // تحديث المحتوى
    $sql = "UPDATE posts SET content='$content' WHERE id=$post_id";

    // التحقق إذا تم رفع ميديا جديدة
    if (!empty($_FILES['media']['name'])) {
        $media_name = time() . "_" . basename($_FILES['media']['name']);
        $target = "./uploads/" . $media_name;

        if (move_uploaded_file($_FILES['media']['tmp_name'], "../uploads/" . $media_name)) {
            $sql = "UPDATE posts SET content='$content', media='$target' WHERE id=$post_id";
        }else {
            echo "Failed to upload media.";
            exit();
        }
    }

    if ($connection->query($sql) === TRUE) {
        header("Location: ../index.php?msg=Post updated successfully");
        exit();
    } else {
        echo "Error updating post: " . $connection->error;
    }
}
?>