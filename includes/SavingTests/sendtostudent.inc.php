<?php
session_start();
require '../Database/dbh.inc.php';
if(isset($_POST['marked'])){
    $testId = $_SESSION['testID']; 
    $markedByTutor = $_POST['marked'];

    $sentToTutor = 1;

    $sql = "UPDATE savedtests SET markedByTutor = ? WHERE idTests = ? AND sentToTutor = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../QuizScreen/quiz.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isi", $markedByTutor, $testId, $sentToTutor);
    mysqli_stmt_execute($stmt);

    //close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}


?>

