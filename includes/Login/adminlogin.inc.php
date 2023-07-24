<!-- The php code that allows a user to login by connecting to the database and checks for possible errors -->

<?php

//make sure that this page is accessed through the login button
if(!isset($_POST['login-submit'])) {
    header("Location: ../../AdminScreen/adminloginscreen.php");
    exit();
}

//include data from database handler page
require '../Database/dbh.inc.php';
    
//retrieve data from user input
$user = $_POST['user'];
$password = $_POST['psw'];

//make sure that the email and password have nonempty fields
if(empty($user) || empty($password)) {
    header("Location: ../../LoginScreen/loginscreen.php?error=emptyfields");
    exit();
} 
        

$sql = "SELECT passwordAdmin FROM adminaccounts WHERE userAdmin=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../LoginScreen/loginscreen.php?error=sqlerror");
    exit();
}            


mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

//$row is an associated array so if empty returns null
if($row == NULL) {
    header("Location: ../../LoginScreen/loginscreen.php?error=nouser");
    exit(); 
}

//make sure that the password is correct
$pwdCheck = password_verify($password, $row['passwordAdmin']);
if(!$pwdCheck) {
    header("Location: ../../LoginScreen/loginscreen.php?error=wrongpwd");
    exit(); 
} 
        
session_start();
$_SESSION['userId'] = $row['idAdmin'];
$_SESSION['emailId'] = $row['emailAdmin'];
$_SESSION['fname'] = $row['userAdmin'];

header("Location: ../../HomeScreen/adminhome.php?login=success");
exit();
                
?>