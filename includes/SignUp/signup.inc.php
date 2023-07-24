<!-- The php code that  allows a potential user to signup by uploading their information to a database and checks for possible errors -->

<?php

//make sure that this page has been accessed by pressing the signup button
if(!isset($_POST['signup-submit'])){
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
$password = $_POST['psw'];
$passwordRepeat = $_POST['repsw'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$time = time();

//if any of the fields are empty or passwords don't match then return to previous page
if(empty($email) || empty($password) || empty($passwordRepeat)){
    header("Location: ../../SignupScreen/signupscreen.php?error=emptyfields&email=".$email);
    exit();
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../SignupScreen/signupscreen.php?error=invalidemail");
    exit();
} else if($password !== $passwordRepeat){
    header("Location: ../../SignupScreen/signupscreen.php?error=passwordcheck&email=".$email);
    exit();
}

//make sure sql statement is viable
$sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../SignupScreen/signupscreen.php?error=sqlerror");
    exit();
}

//now insert information into placeholder positions and check if there exist any duplicates in database
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
if($resultCheck>0) {
    header("Location: ../../SignupScreen/signupscreen.php?error=emailtaken");
    exit();
}

//Create values for the verification key and time when the sign up was made
date_default_timezone_set('Pacific/Auckland');
$date = time();
$bytes = random_bytes(3);
$randomCode = bin2hex($bytes);
$vkey = md5($date.$lname.$fname.$randomCode);
$verified = 0;

$sql = "INSERT INTO users (firstName, lastName, emailUsers, pwdUsers, vkey, verified, createDate) VALUES (?,?,?,?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../SignupScreen/signupscreen.php?error=sqlerror");
    exit();
}  

//PASSWORD_DEFAULT is the most uptodate hashing function so is most secure
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          
//if no duplicates exist insert user information including hashed password into database table called users
mysqli_stmt_bind_param($stmt, "sssssii", $fname, $lname, $email, $hashedPwd, $vkey, $verified, $time);
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
$mail->Subject = "Email Verification";
$mail->Body = "<a href='http://localhost/deltamaths/SignupScreen/signupverified.php?vkey=".$vkey."'>Register Account</a>";
if(!$mail->Send()){
    header("Location: ../../SignupScreen/signupscreen.php?error=maildidntsend");
    exit();
}
    
//close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo 'Check your email to verify your email address';


exit();


?>
