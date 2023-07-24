<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login</title>
        <link rel="stylesheet" href="loginscreen_style.css">
    </head>
    <body>
        <div class="back"> 
            <h1>Admin Login</h1>
            <form action="../includes/Login/adminlogin.inc.php" autocomplete="off" method="post">
                <div class ="imgcontainer">
                    <img src="../images/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="Enter Username" name="user" required>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                    <button type="submit" name="login-submit">Login</button>
                </div>
            </form>
            <a href='forgotpassword.php'>
                        <button>
                        Forgotten your password?
                        </button>
                    </a>
        </div>
    </body>
</html>