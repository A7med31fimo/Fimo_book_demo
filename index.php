<?php
include("./db/get_posts.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ./pages/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Facebook</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="./index.php" style="text-decoration: none; background-color: #1e4798ff;padding:10px;border-radius:15px; cursor: pointer; color:white;">
            <h2>Fimo Book</h2>
        </a>
        <input type="text" placeholder="Search...">
        <h1>WELCOME, <?= htmlspecialchars($_SESSION['user_name']) ?> 🎉</h1>
        <a href="logout.php"  style="text-decoration: none; background-color: #1e4798ff;padding:10px;border-radius:15px; cursor: pointer; color:white;">Logout</a>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Menu</h3>
            <div class="menu">
                <a href="#">🏠 Home</a>
                <a href="#">👥 Friends</a>
                <a href="#">📄 Pages</a>
                <a href="#">⚙️ Settings</a>
            </div>
        </div>

        <!-- Posts -->
        <div id="postsContainer" class="posts">
            <div class="create-post">
                <form action="./db/upload_post.php" method="POST" enctype="multipart/form-data">
                    <textarea name="content" rows="3" placeholder="What's on your mind?"></textarea>
                    <input type="file" name="media" accept="image/*,video/*" style="margin-top: 10px;">
                    <button type="submit" name='btn_upload'>Post</button>
                </form>
            </div>

            <?php
            if (isset($result) && $result->num_rows > 0) {
                echo "<h2>All Posts </h2><br>";
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='post'>
                        <div class='post-header' style='display: flex; align-items: center; justify-content: space-between;'>
                            <!-- User Info -->
                            <div style='display: flex; align-items: center; gap: 10px;'>
                                <img src='https://i.pravatar.cc/150?u=" . $row['user_id'] . "' 
                                     alt='" . htmlspecialchars($row['name']) . "' 
                                     style='width: 40px; height: 40px; border-radius: 50%;'>
                                <h4 style='margin: 0;'>" . htmlspecialchars($row['name']) . "</h4>
                            </div>

                            <!-- Actions -->
                            <div style='display: flex; gap: 15px;'>
                                <a href='./pages/edit_page.php?post_id=" . $row['id'] . "' 
                                   style='color: blue; text-decoration: none; font-weight: bold;'
                                   onclick=\"return confirm('Are you sure you want to edit this post?');\"
                                   >
                                   Edit
                                </a>
                                <a href='./db/delete_post.php?post_id=" . $row['id'] . "'   
                                   style='color: red; text-decoration: none; font-weight: bold;'  
                                   onclick=\"return confirm('Are you sure you want to delete this post?');\">
                                   Delete
                                </a>
                            </div>
                        </div>

                        <div class='post-content'>
                            <p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";

                    if (!empty($row['media'])) {
                        $ext = strtolower(pathinfo($row['media'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<div style='text-align:center; margin:15px 0;'>
                                    <img src='" . htmlspecialchars($row['media']) . "' 
                                        style='width:100%; max-width:600px; height:400px; 
                           object-fit:cover; border-radius:12px; 
                           box-shadow:0 4px 12px rgba(0,0,0,0.2);'>
                                  </div>";
                        } elseif (in_array($ext, ['mp4', 'webm'])) {
                            echo "<div style='text-align:center; margin:15px 0;'>
                                    <video controls style='width:100%; max-width:600px; max-height:800px; 
                              object-fit:cover; border-radius:12px; 
                              box-shadow:0 4px 12px rgba(0,0,0,0.2);'>
                                        <source src='" . htmlspecialchars($row['media']) . "' type='video/$ext'>
                                    </video>
                                  </div>";
                        }
                    }

                    echo "      <small style='color:#555;'>Posted on: " . htmlspecialchars($row['created_at']) . "</small>
                        </div>
                    </div>";
                }
            } else {
                echo "<center><p style='color:gray;'>No posts found.</p></center>";
            }
            ?>
        </div>

        <!-- Contacts -->
        <div class="contacts">
            <center style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
                <img src="./uploads/friends.png"  alt="online friends">
                <h3>Online Friends</h3>
            </center>
            <a href="#" class="contact">
                <img src="https://i.pravatar.cc/150?img=11" alt="Karim">
                <span>🟢 Karim</span>
            </a>
            <a href="#" class="contact">
                <img src="https://i.pravatar.cc/150?img=14" alt="Huda">
                <span>🟢 Huda</span>
            </a>
            <a href="#" class="contact">
                <img src="https://i.pravatar.cc/150?img=17" alt="Amr">
                <span>🟢 Amr</span>
            </a>
            <a href="#" class="contact">
                <img src="https://i.pravatar.cc/150?img=20" alt="Rania">
                <span>🟢 Rania</span>
            </a>
        </div>
    </div>

</body>

</html>