<?php
session_start();
$uid = $_SESSION['userId'];
$examid = $_SESSION['testID'];
$inputanswers = $_POST['inputa'];
$inputworkings = $_POST['inputw'];

$inputanswers = base64_encode(serialize($inputanswers));
$inputworkings = base64_encode(serialize($inputworkings));

date_default_timezone_set('Pacific/Auckland');
$time = time();

require '../Database/dbh.inc.php';

//make sure sql statement is viable
$sql = "SELECT * FROM savedexams WHERE idExams=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    exit();
}

//now insert information into placeholder positions and check if there exist any duplicates in database
mysqli_stmt_bind_param($stmt, "s", $examid); //need to pull in test id
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
if($resultCheck>0) {
    $sql = "UPDATE savedexams SET submittedAnswers = ?, submittedWorkings = ?, saveddates = ? WHERE idExams = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: /deltamaths/quiz.php?error=sqlerror");
        exit();
    } 
    mysqli_stmt_bind_param($stmt, "ssis", $inputanswers, $inputworkings, $time, $examid);
    mysqli_stmt_execute($stmt);
    
    //close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

    
//close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>


