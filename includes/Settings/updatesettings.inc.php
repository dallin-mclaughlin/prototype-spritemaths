<?php
session_start();
require '../Database/dbh.inc.php';
if(isset($_POST['advertisevalue'])){
    $advertiseValue = $_POST['advertisevalue'];
    $userID = $_SESSION['userId'];
    
    $sql = "UPDATE users SET advertiseTutor = ? WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $advertiseValue, $userID);
    mysqli_stmt_execute($stmt);
}

//the only value that can be passed through here is 0 so this means the tutorship will be cancelled
if(isset($_POST['tutorvalue'])){
    $tutorValue = $_POST['tutorvalue'];
    $userID = $_SESSION['userId'];
    $advertiseTutor = 0;
    
    $sql = "UPDATE users SET isTutor = ? WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $tutorValue, $userID);
    mysqli_stmt_execute($stmt);

    $sql = "UPDATE users SET advertiseTutor = ? WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $advertiseTutor, $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM tutorstudentrelations WHERE idTutor = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
}
?>