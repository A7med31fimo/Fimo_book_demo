<?php
session_start();
include("../db/db_config.php"); // هنا الاتصال بقاعدة البيانات

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, name, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: ../index.php"); // بعد الدخول يروح للهوم
            exit;
        } else {
            echo "
            <br>
            <p style='color:red;'>Invalid password!</p>";
        }
    } else {
        echo "
        <br>
        <p style='color:red;'>No user found with this email!</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        input {
            
            width: 92%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #4267B2;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #365899;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p>Don’t have an account? <a href="register.php">Sign Up</a></p>
    </form>
</body>

</html>