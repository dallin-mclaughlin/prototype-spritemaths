<!-- The php code that allows a user to login by connecting to the database and checks for possible errors -->

<?php

//make sure that this page is accessed through the login button
if(!isset($_POST['password-reset'])) {
    header("Location: ../../LoginScreen/passwordreset.php");
    exit();
}

//include data from database handler page
require '../Database/dbh.inc.php';
    
//retrieve data from user input
$email = $_POST['email'];
$password = $_POST['psw'];
$password2 = $_POST['psw2'];

//make sure that the email and password have nonempty fields
if(empty($email) || empty($password)) {
    header("Location: ../../LoginScreen/passwordreset.php?error=emptyfields");
    exit();
} 

if($password != $password2) {
    header("Location: ../../LoginScreen/passwordreset.php?error=passwordsneedtomatch");
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
    header("Location: ../../LoginScreen/passwordreset.php?error=nouser");
    exit(); 
}

//reset the account with the new password
$sql = "UPDATE users SET pwdUsers = ? WHERE emailUsers = ?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../LoginScreen/passwordreset.php?error=sqlerror");
    exit();
} 

$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $email);
mysqli_stmt_execute($stmt);
        


header("Location: ../../LoginScreen/loginscreen.php?message=passwordhaschanged");
exit();
                
?>