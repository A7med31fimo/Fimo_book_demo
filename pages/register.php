<?php 
include("../db/db_config.php");
include("../db/register.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
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
            width: 320px;
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

    <form method="POST" action="">
        <h2 style="text-align:center;">Sign Up</h2>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <!-- هنا بنعرض الرسائل -->
        <?php if (!empty($message))
            echo $message; ?>
        <button type="submit" name="register">Register</button>
        <p style="text-align:center;">Already have an account? <a href="login.php">Login</a></p>
    </form>

</body>

</html>