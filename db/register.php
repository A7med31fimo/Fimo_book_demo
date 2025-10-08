<?php
require "db_config.php";
$message = ""; // مكان نخزن فيه الرسالة

if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // تأكد إن الإيميل مش موجود
    $check = $connection->prepare("SELECT id FROM users WHERE email=?");
    $check->execute([$email]);
    $check=$check->fetchAll(PDO::FETCH_ASSOC);

    if (count($check) > 0) {
        $message = "<div style='background:#f8d7da; color:#842029; padding:10px; border-radius:5px; margin-bottom:10px; text-align:center;'>
                       ⚠️ Email already exists!
                    </div>";
    } else {
        $stmt = $connection->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
        
        if ($stmt->execute([$name, $email, $password])) {
            $message = "<div style='background:#d1e7dd; color:#0f5132; padding:10px; border-radius:5px; margin-bottom:10px; text-align:center;'>
                           ✅ Registration successful! <br> <a href='login.php'>Login here</a>
                        </div>";
        } else {
            $message = "<div style='background:#f8d7da; color:#842029; padding:10px; border-radius:5px; margin-bottom:10px; text-align:center;'>
                           ❌ Error: " . $stmt->errorInfo() . "
                        </div>";
        }
    }}
?>