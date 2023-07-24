<!-- The header document that is applied to all pages outside of the signup/login pages -->

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Header/header_style.css?"<?php echo time();?>;>
        <link rel="icon" type="image/x-icon" sizes="256x256" href="../images/faviconSpriteMaths256.ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container-links">
            <div class="links">
                <nav>
                    <li><a id="logo" href="#"><image class="logo_border" src="images/graphicSVG/logo_s_border.svg"></a></li>
                    <li><a href = "home.php">Home</a></li>
                    <li><a href = "#">Purpose</a></li>
                    <li><a href = "#">Subject Content</a><li>
                    <li><a href = "#">Future Developments</a></li>
                    <li><a href = "#">Contact</a></li>
                    <!--<a href = "#">Subject Content</a>-->
                    <!--<a href = "../TutorAdvertising/findatutor.php">Find a Tutor</a>-->
                    <!--<a href = "../BecomeTutor/becomeatutor.php">Become a Tutor</a>-->
                    <!--<a href ="#">Virtual Shop</a>-->
                    <!--<a href ="#">Diversity, Equity and Inclusion</a>-->
                </nav>
                <div class ="name"> Kia Ora, 
                    <?php 
                        echo $_SESSION['fname'];
                        echo " ";
                        echo $_SESSION['lname'];
                    ?>
                </div>
            </div>
            <div class="dropdown">
                <hr>
                <hr>
                <hr>
                <div class="dropdown-content">
                    <!--<a href="../Requests/requests.php">Requests</a>-->
                    <!--<a href="../Settings/settings.php">Account</a>-->
                    <a href="includes/Logout/logout.inc.php">Logout</a>
                </div>
            </div>
        </div>
    </body>
</html>