<?php
session_start();
$uid = $_SESSION['userId'];
$testid = $_SESSION['testID'];
$inputanswers = $_POST['inputa'];
$inputworkings = $_POST['inputw'];
$logicalreasoningpoints = $_POST['logicalrp'];

$inputanswers = base64_encode(serialize($inputanswers));
$inputworkings = base64_encode(serialize($inputworkings));
$logicalreasoningpoints = serialize($logicalreasoningpoints);

date_default_timezone_set('Pacific/Auckland');
$time = time();

require '../Database/dbh.inc.php';

//make sure sql statement is viable
$sql = "SELECT * FROM savedtests WHERE idTests=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    exit();
}

//now insert information into placeholder positions and check if there exist any duplicates in database
mysqli_stmt_bind_param($stmt, "s", $testid); //need to pull in test id
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
if($resultCheck>0) {
    $sql = "UPDATE savedtests SET submittedAnswers = ?, submittedWorkings = ?, logicalReasoningPoints = ?, saveddates = ? WHERE idTests = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: /deltamaths/quiz.php?error=sqlerror");
        exit();
    } 
    mysqli_stmt_bind_param($stmt, "sssis", $inputanswers, $inputworkings, $logicalreasoningpoints, $time, $testid);
    mysqli_stmt_execute($stmt);
    
    //close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>


