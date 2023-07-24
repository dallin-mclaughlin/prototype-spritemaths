<?php 
    require '../Database/dbh.inc.php';

    $emailAdmin = 'nillad12@gmail.com';
    $userAdmin = 'nillad12';
    $passwordAdmin = 'dallin';

    $sql = "INSERT INTO adminaccounts (emailAdmin, userAdmin, passwordAdmin) VALUES (?,?,?);";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../SignupScreen/signupscreen.php?error=sqlerror");
        exit();
    }  

    //PASSWORD_DEFAULT is the most uptodate hashing function so is most secure
    $hashedPwd = password_hash($passwordAdmin, PASSWORD_DEFAULT);
            
    //if no duplicates exist insert user information including hashed password into database table called users
    mysqli_stmt_bind_param($stmt, "sss", $emailAdmin, $userAdmin, $hashedPwd);
    mysqli_stmt_execute($stmt);
?>