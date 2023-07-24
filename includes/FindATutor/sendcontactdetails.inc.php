<?php
require '../Database/dbh.inc.php';
session_start();
if(!isset($_POST['student'])){
    header('../../TutorAdvertising/findatutor.php');
    exit();
}


$tutorId = $_SESSION['userId'];
$studentId = unserialize(base64_decode($_POST['student']));
$sentDetails=1;

$sql = "UPDATE tutorstudentrelations SET sentDetails=? WHERE (idTutor, idStudent) = (?,?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}  

//if no duplicates exist insert user information including hashed password into database table called users
mysqli_stmt_bind_param($stmt, "iii", $sentDetails, $tutorId, $studentId);
mysqli_stmt_execute($stmt);

header("Location: ../../TutorAdvertising/findatutor.php?message=contactdetailssent");
exit();



?>