<?php
include("../db/db_config.php");


if (!isset($_GET['post_id'])) {
    die("Post ID is required.");
}

$post_id = intval($_GET['post_id']);

$sql = "SELECT * FROM posts WHERE id = ? LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->execute([$post_id]);

if ($stmt->rowCount() === 0) {
    die("Post not found.");
}

// ✅ بدل fetch_assoc() بـ fetch(PDO::FETCH_ASSOC)
$post = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .edit-container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #4267B2;
        }

        textarea {
            resize: none;
            border-radius: 8px;
        }

        .media-preview {
            margin: 15px 0;
            text-align: center;
        }

        .media-preview img,
        .media-preview video {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="edit-container">
        <h2>✏️ Edit Post</h2>
        <form action="../db/update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?= htmlspecialchars($post['id']) ?>">

            <!-- Post Content -->
            <div class="mb-3">
                <label for="content" class="form-label">Post Content</label>
                <textarea name="content" id="content" class="form-control" rows="4" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <!-- Current Media -->
            <div class="mb-3">
                <label class="form-label">Current Media:</label>
                <div class="media-preview">
                    <?php if (!empty($post['media'])): ?>
                        <?php
                        $ext = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                        $mediaPath = htmlspecialchars($post['media']);
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<img src='../$mediaPath' alt='Post Image'>";
                        } elseif (in_array($ext, ['mp4', 'webm'])) {
                            echo "<video controls><source src='../$mediaPath' type='video/$ext'></video>";
                        }
                        ?>
                    <?php else: ?>
                        <p style="color: gray;">No media uploaded.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upload New Media -->
            <div class="mb-3">
                <label for="media" class="form-label">Change Media (optional)</label>
                <input type="file" name="media" id="media" class="form-control" accept="image/*,video/*">
            </div>

            <!-- Submit -->
            <button type="submit" name="btn_update" class="btn btn-primary">💾 Update Post</button>
        </form>
    </div>

</body>

</html>