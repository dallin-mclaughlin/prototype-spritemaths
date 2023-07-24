<?php
session_start();
require '../Database/dbh.inc.php';
if(isset($_POST['sent'])&&isset($_POST['tutor'])){
    $testId = $_SESSION['testID']; 
    $sentToTutor = $_POST['sent'];
    $tutorId = $_POST['tutor'];

    $sql = "UPDATE savedtests SET idTutor = ?, sentToTutor = ? WHERE idTests = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../QuizScreen/quiz.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iis", $tutorId, $sentToTutor, $testId);
    mysqli_stmt_execute($stmt);

    //close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}


?>

