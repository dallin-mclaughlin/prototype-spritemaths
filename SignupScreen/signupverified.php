<?php

//pull information from the database handler page
require '../includes/Database/dbh.inc.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/PHPMailer-master/src/Exception.php';

//check to see if vkey is in header if it is then make it a useable variable
if(isset($_GET['vkey'])&&!$_GET['vkey']){
    echo 'please supply a verification key';
    exit();
}
$verifykey = $_GET['vkey'];

//check to see if an account has been made with the given vkey
$sql = "SELECT emailUsers FROM users WHERE vkey=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: signupverified.php?error=sqlerror");
    exit();
}      

mysqli_stmt_bind_param($stmt, "s", $verifykey);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);

if($resultCheck==0) {
    header("Location: signupverified.php?error=invalidverificationcode");
    exit();
}

//now check that this account hasn't already been verified
$sql = "SELECT firstName, lastName, emailUsers, verified, createDate FROM users WHERE vkey=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: signupverified.php?error=sqlerror");
    exit();
}      

mysqli_stmt_bind_param($stmt, "s", $verifykey);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$fname = $row['firstName'];
$lname = $row['lastName'];
$email = $row['emailUsers'];
$verified = $row['verified'];
$createDate = $row['createDate'];

//make sure the account has not already been verified
if($row['verified']!=0) {
    header("Location: signupverified.php?error=thisaccounthasbeenpreviouslyverified");
    echo "You can already log in LOL";
    exit();
}

date_default_timezone_set('Pacific/Auckland');
$secondsInADay = 86400;
//If verification code has expired send a new code to the same address
if(($createDate+$secondsInADay)<time()){
    header("Location: signupverified.php?error=verificationcodehasexpired");
    echo 'An updated verification code has been sent to your email.';

    $date = time();
    $bytes = random_bytes(3);
    $randomCode = bin2hex($bytes);
    $vkey = md5($date.$lname.$fname.$randomCode);

    $sql = "UPDATE users SET vkey = ? WHERE emailUsers = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: signupverified.php?error=sqlerror");
        exit();
    } 

    mysqli_stmt_bind_param($stmt, "ss", $vkey, $email);
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
    $mail->Body = "<a href='http://localhost/deltamaths/SignupScreen/signupverified.php?vkey=".$vkey."'>Register Account Again</a>";
    if(!$mail->Send()){
        header("Location: ../../SignupScreen/signupscreen.php?error=maildidntsend");
        exit();
    }       
    exit();
}


$sql = "UPDATE users SET verified = ? WHERE vkey = ?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: signupverified.php?error=sqlerror");
    exit();
} 

$verified = 1;
mysqli_stmt_bind_param($stmt, "ss", $verified, $verifykey);
mysqli_stmt_execute($stmt);

echo 'Your account has been verified';

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Verification Complete</title>
        <!-- <link rel="stylesheet" href="signupscreen_style.css"> -->
    </head>
    <body>
        <div class="back"> 
            <h1>Verification Complete</h1>

            <a href='../LoginScreen/loginscreen.php'>
                <button>
                Go to Log in Page
                </button>
            </a>
        </div>
    </body>
</html>