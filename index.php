<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>spritemaths</title>
        <link rel="stylesheet" href="index_style.css?"<?php echo time();?>;>
        <link rel="icon" type="image/x-icon" sizes="256x256" href="images/faviconSpriteMaths256.ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    </head>
    <body>
        <div id="signup-container" class="formcontainer" style="display:none">
        <div class="form">
        <form action="includes/SignUp/signup.inc.php" method="post">
            <div class ="imgcontainer">
                <img src="images/graphicSVG/avatarimage.png" alt="Avatar" class ="avatar">
            </div>
            <div class ="entrycontainers">
                <input type="text" placeholder="First Name" name="firstname" required>
                <input type="text" placeholder="Last Name" name="lastname" required>
                <input type="text" placeholder="Enter Email" name="email" required>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <input type="password" placeholder="Re-Enter Password" name="repsw" required>
                <button type="submit" name="signup-submit">Sign Up</button>
            </div>
        </form>
        <a> <button id="signup-exit"></button></a>
        </div>
        </div>
        <div id="login-container" class = "formcontainer" style="display:none">
        <div id="login-form" class="form">
        <form action="includes/Login/login.inc.php" autocomplete="off" method="post">
                <div class ="imgcontainer">
                    <img src="images/graphicSVG/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                    <button id="login-submit" type="submit" name="login-submit">Login</button>
                    <!--<a href='forgotpassword.php'>Forgot your password?</a>-->
                </div>
        </form>
        <a> <button id="login-exit"></button></a>
        </div>
        </div>
        <div class="logo">
        </div>
        <div class="spritemathslogo">
            <image class="logo_border" src="images/graphicSVG/logo_s_border.svg">
            <image class="spritemaths" src="images/graphicSVG/spritemaths.svg">
            <div class = "text">
                <h1>Become <span>a</span> Master <span>of</span> Mathematics</h1>
            </div>
            <image class="graph" src="images/graphicSVG/graph2.svg">
        </div>
        <div class = "hoveringbuttons">
            <a>
                <button id="login-button" class = "login">
                    LOGIN
                </button>
            </a>
            <a >
                <button id="signup-button" class = "signup">
                    SIGN UP
                </button>
            </a>
        </div>
        <div class ="feature">
            <div class="row">
            <div class = "texts">
                <h1>Unlimited and Randomised</h1>
                <p>Algorithms randomly generate similar styled questions to reinforce concept learning</p>
            </div>
            <image class="featurepic" src="images/graphicSVG/feature1.svg">
            </div>
        </div>
        <div class="feature-grey">
            <div class="row">
            <image class="featurepic" src="images/graphicSVG/feature3.svg">
            <div class = "texts">
                <h1>NCEA-type style</h1>
                <p>Questions are designed with the end goal to help students succeed in NCEA assessments</p>
            </div>
            </div>
        </div>
        <div class="feature">
        <div class="row">
            <div class = "texts">
                <h1>Written Answers</h1>
                <p>Students have to do their own thinking to generate their own answers by reading questions carefully</p>
            </div>
            <image class="featurepic" src="images/graphicSVG/feature4.svg">
            </div>
        </div>
        <div class="feature-grey">
        <div class="row">
            <image class="featurepic" src="images/graphicSVG/feature2.svg">
            <div class = "texts">
                <h1>Graphs and Visuals</h1>
                <p>Computer generated graphs allow students to connect algebra to visual representations</p>
            </div>
            </div>
        </div>
        <!--<a href="../Admin/adminloginscreen.php">
                <button class = "adminlogin">
                    Admin Login
                </button>
        </a>-->
        <script>
            $(document).ready(function() {
                var loginDiv = document.getElementById('login-container');
                var loginButton = document.getElementById('login-button');
                var exitLoginButton = document.getElementById('login-exit');

                var signupDiv = document.getElementById('signup-container');
                var signupButton = document.getElementById('signup-button');
                var exitSignupButton = document.getElementById('signup-exit');

                //Return Button
                loginButton.addEventListener('click', () =>  {
                    loginDiv.style.display = 'inline-block';
                });

                exitLoginButton.addEventListener('click', ()=> {
                    loginDiv.style.display = 'none';
                })

                signupButton.addEventListener('click', () =>  {
                    signupDiv.style.display = 'inline-block';
                });

                exitSignupButton.addEventListener('click', ()=> {
                    signupDiv.style.display = 'none';
                })
            })
        </script>
    </body>
</html>

<?php
    require 'Footer/footer.php';
?>