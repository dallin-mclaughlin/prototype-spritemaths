<!-- The php code that allows a user to login by connecting to the database and checks for possible errors -->

<?php

//make sure that this page is accessed through the login button
if(!isset($_POST['login-submit'])) {
    header("Location: ../../LoginScreen/loginscreen.php");
    exit();
}

//include data from database handler page
require '../Database/dbh.inc.php';
    
//retrieve data from user input
$email = $_POST['email'];
$password = $_POST['psw'];

//make sure that the email and password have nonempty fields
if(empty($email) || empty($password)) {
    header("Location: ../../LoginScreen/loginscreen.php?error=emptyfields");
    exit();
} 
        

$sql = "SELECT * FROM users WHERE emailUsers=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../LoginScreen/loginscreen.php?error=sqlerror");
    exit();
}            


mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

//$row is an associated array so if empty returns null
if($row == NULL) {
    header("Location: ../../LoginScreen/loginscreen.php?error=nouser");
    exit(); 
}

if($row['verified']==0){
    header("Location: ../../LoginScreen/loginscreen.php?error=notverified ");
    exit();
}

//make sure that the password is correct
$pwdCheck = password_verify($password, $row['pwdUsers']);
if(!$pwdCheck) {
    header("Location: ../../LoginScreen/loginscreen.php?error=wrongpwd");
    exit(); 
} 
        
session_start();
$_SESSION['userId'] = $row['idUsers'];
$_SESSION['emailId'] = $row['emailUsers'];
$_SESSION['fname'] = $row['firstName'];
$_SESSION['lname'] = $row['lastName'];

header("Location: ../../home.php?login=success");
exit();
                
?>