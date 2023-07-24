<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="loginscreen_style.css">
    </head>
    <body>
        <div class="back"> 
        <div class="logo">
            <image class="spritemaths" src="../images/graphicSVG/spritemaths.svg">
            <image class="logo_border" src="../images/graphicSVG/logo_s_border.svg">
        </div>
        </div>
        <div class="form" >
        <form action="../includes/Login/login.inc.php" autocomplete="off" method="post">
                <div class ="imgcontainer">
                    <img src="../images/graphicSVG/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                    <button id="login-submit" type="submit" name="login-submit">Login</button>
                    <a href='forgotpassword.php'>Forgot your password?</a>
                </div>
        </form>
        <a href="../FirstScreen/index.php"> <button id="exit"></button></a>
        </div>
    </body>
</html>