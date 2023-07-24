<?php
require '../Database/dbh.inc.php';
session_start();
if(!isset($_POST['tutor'])&&!isset($_POST['cancel'])){
    header('../../TutorAdvertising/findatutor.php');
    exit();
}

if(isset($_POST['tutor'])){
    $studentId = $_SESSION['userId'];
    $tutorId = unserialize(base64_decode($_POST['tutor']));

    $sql = "INSERT INTO tutorstudentrelations (idTutor, idStudent) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }  


    //if no duplicates exist insert user information including hashed password into database table called users
    mysqli_stmt_bind_param($stmt, "ii", $tutorId, $studentId);
    mysqli_stmt_execute($stmt);

    header("Location: ../../TutorAdvertising/findatutor.php?message=messagesent");
    exit();

} else if(isset($_POST['cancel'])){

    $tutorId = unserialize(base64_decode($_POST['cancel']));
    $studentId = $_SESSION['userId'];
    $sql = "DELETE FROM tutorstudentrelations WHERE (idTutor, idStudent)=(?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../TutorAdvertising/findatutor.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $tutorId, $studentId);
    mysqli_stmt_execute($stmt);
    header("Location: ../../TutorAdvertising/findatutor.php?message=requestdeleted");
    exit();
}


?>