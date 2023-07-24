<?php

//pull information from the database handler page
require '../includes/Database/dbh.inc.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/PHPMailer-master/src/Exception.php';

//check to see if vkey is in header if it is then make it a useable variable
if(isset($_GET['lostPKey'])&&!$_GET['lostPKey']){
    echo 'please supply a verification key';
    exit();
}
$passwordResetKey = $_GET['lostPKey'];

//check to see if an account has been made with the given vkey
$sql = "SELECT emailUsers FROM users WHERE lostPasswordKey=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: passwordreset.php?error=sqlerror");
    exit();
}      

mysqli_stmt_bind_param($stmt, "s", $passwordResetKey);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);

if($resultCheck==0) {
    header("Location: passwordreset.php?error=invalidresetcode");
    exit();
}

//now check that this account hasn't already been verified
$sql = "SELECT emailUsers, resetPasswordTime, verifiedP FROM users WHERE lostPasswordKey=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: passwordreset.php?error=sqlerror");
    exit();
}      

mysqli_stmt_bind_param($stmt, "s", $passwordResetKey);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$verifiedP = $row['verifiedP'];
$email = $row['emailUsers'];
$timePast = $row['resetPasswordTime'];

//make sure the account has not already been verified
if($verifiedP!=0) {
    header("Location: signupverified.php?error=thisaccounthasntreceivedaresetkey");
    echo "Go to the Login Screen";
    exit();
}

date_default_timezone_set('Pacific/Auckland');
$secondsInAnHour = 3600;
//If verification code has expired send a new code to the same address
if(($timePast+$secondsInAnHour)<time()){
    header("Location: signupverified.php?error=resetcodehasexpired");
    echo 'An updated resetpassword code has been sent to your email.';

    $date = time();
    $bytes = random_bytes(2);
    $randomCode = bin2hex($bytes);
    $lostPKey = md5($time.$email.$randomCode);

    $sql = "UPDATE users SET lostPasswordKey = ? WHERE emailUsers = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: signupverified.php?error=sqlerror");
        exit();
    } 

    mysqli_stmt_bind_param($stmt, "ss", $lostPKey, $email);
    mysqli_stmt_execute($stmt);

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.mailtrap.io';
    $mail->Port = '2525';
    $mail->isHTML();
    $mail->Username = '16bf5d3a215531';
    $mail->Password = '769971c7c9e846';
    $mail->SetFrom('no-reply@deltamaths.com');


    //Here send the mail
    $mail->AddAddress($email);
    $mail->Subject = "Email Verification";
    $mail->Body = "<a href='http://localhost/deltamaths/LoginScreen/passwordreset.php?lostPKey=".$lostPKey."'>Register Account Again</a>";
    if(!$mail->Send()){
        header("Location: ../../LoginScreen/passwordreset.php?error=maildidntsend");
        exit();
    }       
    exit();
}


$sql = "UPDATE users SET verifiedP = ? WHERE lostPasswordKey = ?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: signupverified.php?error=sqlerror");
    exit();
} 

$verified = 1;
mysqli_stmt_bind_param($stmt, "ss", $verified, $passwordResetKey);
mysqli_stmt_execute($stmt);

//echo 'Your account has been verified';

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" href="loginscreen_style.css">
    </head>
    <body>
        <div class="back"> 
            <h1>Reset Password</h1>
            <form action="../includes/Login/resetpassword.inc.php" autocomplete="off" method="post">
                <div class ="imgcontainer">
                    <img src="../images/avatarimage.png" alt="Avatar" class ="avatar">
                </div>
                <div class ="entrycontainers">
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <input type="password" placeholder="Enter New Password" name="psw" required>
                    <input type="password" placeholder="Re-enter New Password" name="psw2" required>
                    <button type="submit" name="password-reset">Reset</button>
                </div>
            </form>
        </div>
    </body>
</html>