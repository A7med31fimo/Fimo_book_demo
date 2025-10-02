<?php

include "db_config.php";

if (isset($_POST['btn_upload'])) {
    $content = $_POST['content'];
    $user_id = 1; // مؤقتاً هنجرب على user ثابت

    $media = null;
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $media_name = time() . "_" . $_FILES['media']['name'];
        $media_tmp = $_FILES['media']['tmp_name'];
        move_uploaded_file($media_tmp, "../uploads/" . $media_name);
        $media = "../uploads/" . $media_name;
    }

    $sql = "INSERT INTO posts (user_id, content, media) VALUES ('$user_id', '$content', '$media')";
    if ($connection->query($sql)) {
        // echo "Post Added Successfully ✅";
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>