<?php

?>



<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password</title>
        <link rel="stylesheet" href="loginscreen_style.css">
    </head>
    <body>
        <div class="back"> 
            <h1>Password Reset</h1>
            <form action="../includes/Login/forgotpassword.inc.php" autocomplete="off" method="post">
                <div class ="imgcontainer">
                    <img src="../images/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <button type="submit" name="reset-password">Send email </button>
                </div>
            </form>
        </div>
    </body>
</html>