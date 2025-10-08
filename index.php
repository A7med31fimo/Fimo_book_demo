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
    <title>FimoBook | Mini Facebook</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- 🌐 Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="./index.php" class="logo">
                <h2>Fimo<span>Book</span></h2>
            </a>
            <input type="text" placeholder="🔍 Search posts, friends...">
        </div>

        <div class="nav-right">
            <button id="themeToggle" class="theme-btn" title="Toggle Dark/Light Mode">🌙</button>
            <a href="./db/logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <!-- 🌄 Cover Section -->
    <header class="cover-section">
        <div class="welcome-banner fade-in">
            <h2>👋 Hey <?= htmlspecialchars($_SESSION['user_name']) ?>, glad to see you back!</h2>
            <p>Share your thoughts, connect with friends, and spread positivity 💬</p>
        </div>
    </header>

    <!-- 🧩 Main Layout -->
    <main class="container">
        <!-- 🧭 Sidebar -->
        <aside class="sidebar">
            <h3>Menu</h3>
            <nav class="menu">
                <a href="#">🏠 Home</a>
                <a href="#">👥 Friends</a>
                <a href="#">📄 Pages</a>
                <a href="#">⚙️ Settings</a>
            </nav>
        </aside>

        <!-- 📰 Posts Section -->
        <section class="posts" id="postsContainer">
            <!-- Create Post -->
            <div class="create-post">
                <form action="./db/upload_post.php" method="POST" enctype="multipart/form-data">
                    <textarea name="content" rows="3" placeholder="What's on your mind?"></textarea>
                    <div class="d-flex align-items-center mt-2">
                        <input class="form-control me-2" type="file" name="media" accept="image/*,video/*" style="max-width:80%;">
                        <button type="submit" name="btn_upload" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>

            <!-- All Posts -->
            <?php if (isset($posts) && count($posts) > 0): ?>
                <h2 class="mt-4 mb-3 text-primary">All Posts</h2>
                <?php foreach ($posts as $post):
                    $likeCount = $connection->query("SELECT COUNT(*) FROM likes WHERE post_id=" . $post['id'])->fetchColumn();
                    $isLiked = $connection->query("SELECT * FROM likes WHERE post_id=" . $post['id'] . " AND user_id=" . $_SESSION['user_id'])->fetch();
                    $comments = $connection->query("
                        SELECT comments.*, users.name 
                        FROM comments 
                        JOIN users ON comments.user_id = users.id 
                        WHERE post_id=" . $post['id'] . " 
                        ORDER BY comments.created_at DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <article class="post" data-post-id="<?= $post['id'] ?>">
                        <header class="post-header d-flex align-items-center mb-2">
                            <img src="https://i.pravatar.cc/150?u=<?= $post['user_id'] ?>" class="rounded-circle me-2" width="45" height="45">
                            <h5 class="mb-0"><?= htmlspecialchars($post['name']) ?></h5>

                        </header>
                        <small class="text-muted">Posted on : <?= htmlspecialchars($post['created_at']) ?></small>

                        <div class="post-content mb-2">
                            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

                            <?php if (!empty($post['media'])):
                                $ext = strtolower(pathinfo($post['media'], PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img src="<?= htmlspecialchars($post['media']) ?>" class="img-fluid rounded mt-2">
                                <?php elseif (in_array($ext, ['mp4', 'webm'])): ?>
                                    <video controls class="rounded mt-2" style="width:100%;max-width:600px;">
                                        <source src="<?= htmlspecialchars($post['media']) ?>" type="video/<?= $ext ?>">
                                    </video>
                            <?php endif;
                            endif; ?>

                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <button class="like-btn"
                                data-liked="<?= $isLiked ? '1' : '0' ?>"
                                style="color:<?= $isLiked ? 'red' : 'gray' ?>">
                                ❤️ <span class="like-count"><?= $likeCount ?></span> Likes
                            </button>
                        </div>

                        <div class="comments mt-3">
                            <div class="d-flex">
                                <input type="text" class="comment-input" placeholder="Write a comment...">
                                <button class="comment-btn">Comment</button>
                            </div>

                            <div class="comment-list mt-2">
                                <?php foreach ($comments as $c): ?>
                                    <div class="comment-item">
                                        <b><?= htmlspecialchars($c['name']) ?>:</b> <?= htmlspecialchars($c['comment']) ?>
                                        <br><small><?= htmlspecialchars($c['created_at']) ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <center>
                    <p class="text-secondary mt-3">No posts found.</p>
                </center>
            <?php endif; ?>
        </section>

        <!-- 👥 Contacts -->
        <aside class="contacts">
            <div class="text-center mb-3">
                <img src="./uploads/friends.png" alt="friends" width="35">
                <h4>Online Friends</h4>
            </div>
            <?php
            $friends = [
                ["img" => 11, "name" => "Karim"],
                ["img" => 14, "name" => "Huda"],
                ["img" => 17, "name" => "Amr"],
                ["img" => 20, "name" => "Rania"],
            ];
            foreach ($friends as $f): ?>
                <a href="#" class="contact">
                    <img src="https://i.pravatar.cc/150?img=<?= $f['img'] ?>" alt="<?= $f['name'] ?>">
                    <span>🟢 <?= $f['name'] ?></span>
                </a>
            <?php endforeach; ?>
        </aside>
    </main>

    <!-- ==================== JS ==================== -->
    <script>
        // ❤️ Like System
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".like-btn").forEach(btn => {
                btn.addEventListener("click", async () => {
                    const post = btn.closest(".post");
                    const postId = post.dataset.postId;
                    try {
                        const res = await fetch("./db/like_post.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "post_id=" + postId
                        });
                        const data = await res.json();
                        if (data.error) return alert(data.error);

                        btn.querySelector(".like-count").textContent = data.count;
                        btn.style.color = data.liked ? "red" : "gray";
                        btn.dataset.liked = data.liked ? "1" : "0";
                    } catch (err) {
                        console.error("Like error:", err);
                    }
                });
            });

            // 💬 Comment System
            document.querySelectorAll(".comment-btn").forEach(btn => {
                btn.addEventListener("click", async () => {
                    const post = btn.closest(".post");
                    const postId = post.dataset.postId;
                    const input = post.querySelector(".comment-input");
                    const comment = input.value.trim();

                    if (!comment) return alert("Please write a comment!");
                    try {
                        const res = await fetch("./db/add_comment.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "post_id=" + postId + "&comment=" + encodeURIComponent(comment)
                        });
                        const data = await res.json();
                        if (data.error) return alert(data.error);

                        const list = post.querySelector(".comment-list");
                        const newComment = document.createElement("div");
                        newComment.className = "comment-item";
                        newComment.innerHTML = `<b>${data.name}:</b> ${data.comment}<br><small>${data.created_at}</small>`;
                        list.prepend(newComment);
                        input.value = "";
                    } catch (err) {
                        console.error("Comment error:", err);
                    }
                });
            });
        });

        // 🌗 Dark Mode Toggle
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;
        if (localStorage.getItem("theme") === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = "☀️";
        }
        themeToggle.addEventListener("click", () => {
            body.classList.toggle("dark-mode");
            const isDark = body.classList.contains("dark-mode");
            localStorage.setItem("theme", isDark ? "dark" : "light");
            themeToggle.innerHTML = isDark ? "☀️" : "🌙";
        });
    </script>
</body>

</html>