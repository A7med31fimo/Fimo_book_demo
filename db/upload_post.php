<?php

require "db_config.php";
session_start();
if (isset($_POST['btn_upload'])) {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id']; // مؤقتاً هنجرب على user ثابت

    $media = null;
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $media_name = time() . "_" . $_FILES['media']['name'];
        $media_tmp = $_FILES['media']['tmp_name'];
        move_uploaded_file($media_tmp, "../uploads/" . $media_name);
        $media = "../uploads/" . $media_name;
    }

    $sql = "INSERT INTO posts (user_id, content, media) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
    if ($stmt->execute([$user_id, $content, $media])) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>