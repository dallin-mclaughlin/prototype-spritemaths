<?php

//make sure that this page has been accessed by pressing the signup button
if(!isset($_POST['reset-password'])){
    header("Location: ../../SignupScreen/signupscreen.php");
    exit();
}


//pull information from the database handler page
require '../Database/dbh.inc.php';
require '../../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/PHPMailer-master/src/SMTP.php';
require '../../PHPMailer-master/PHPMailer-master/src/Exception.php';

//information that user has entered into input fields
$email = $_POST['email'];
$time = time();

//if any of the fields are empty or passwords don't match then return to previous page
if(empty($email)){
    header("Location: ../../LoginScreen/forgotpassword.php?error=emptyfields&email=".$email);
    exit();
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../LoginScreen/forgotpassword.php?error=invalidemail");
    exit();
} 

//make sure sql statement is viable
$sql = "SELECT * FROM users WHERE emailUsers=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../LoginScreen/forgotpassword.php?error=sqlerror");
    exit();
}

//now insert information into placeholder positions and check if there exist any duplicates in database
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
if($resultCheck==0) {
    header("Location: ../../LoginScreen/forgotpassword.php?error=nosuchaccountexists");
    exit();
}

//Create values for the verification key and time when the sign up was made
date_default_timezone_set('Pacific/Auckland');
$time = time();
$bytes = random_bytes(2);
$randomCode = bin2hex($bytes);
$lostPKey = md5($time.$email.$randomCode);
$verifiedP = 0;

$sql = "UPDATE users SET lostPasswordKey = ?, resetPasswordTime = ?, verifiedP = ? WHERE emailUsers=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../LoginScreen/forgotpassword.php?error=sqlerror");
    exit();
}  
          
//if no duplicates exist insert user information including hashed password into database table called users
mysqli_stmt_bind_param($stmt, "siis", $lostPKey, $time, $verifiedP, $email);
mysqli_stmt_execute($stmt);


//Create PHPMailer class
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
$mail->Subject = "Password Reset";
$mail->Body = "<a href='http://localhost/deltamaths/LoginScreen/passwordreset.php?lostPKey=".$lostPKey."'>Reset Password</a>";
if(!$mail->Send()){
    header("Location: ../../LoginScreen/forgotpassword.php?error=maildidntsend");
    exit();
}
    
//close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo 'Check your email and click the link to reset your password';





?>

