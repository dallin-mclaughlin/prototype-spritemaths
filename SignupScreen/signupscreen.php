<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="signupscreen_style.css">
    </head>
    <body>
        <div class="back"> 
        <div class="logo">
            <image class="spritemaths" src="../images/graphicSVG/spritemaths.svg">
            <image class="logo_border" src="../images/graphicSVG/logo_s_border.svg">
        </div>
        </div>
        <div class="form">
            <form action="../includes/SignUp/signup.inc.php" method="post">
                <div class ="imgcontainer">
                    <img src="../images/graphicSVG/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="First Name" name="firstname" required>
                    <input type="text" placeholder="Last Name" name="lastname" required>
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                    <input type="password" placeholder="Re-Enter Password" name="repsw" required>
                    <button type="submit" name="signup-submit"> Sign Up</button>
                </div>
            </form>
            <a href="../FirstScreen/index.php"> <button id="exit"></button></a>
            </div>
    </body>
</html>

<?php
    if(isset($_GET['error']))
    {
        //I don't get an error which is good but what I need to do is put the text in a box
        //or change the font colour so that it is visible.
        if($_GET['error']=='emailtaken')
        {
            echo 'Sorry that email has been taken.';
        }
    }
?>


<!-- 
    - I need to add a button that allows you to go the login screen
    - I need to tell the user in plain english whether an error has occured
 -->


