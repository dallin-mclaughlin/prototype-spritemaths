<?php

$questionBlurbs = base64_encode(serialize($questionBlurbs));
$questions = base64_encode(serialize($questions));
$answers = base64_encode(serialize($answers));
$submittedanswers = base64_encode(serialize($submittedanswers));
$submittedworkings = base64_encode(serialize($submittedWorkings));
$imagereferences = base64_encode(serialize($imagereferences));
$logicalReasoningPoints = serialize($logicalReasoningPoints);
$uid = $_SESSION['userId'];

if($createdByTutor){
     $sql = "INSERT INTO savedtests (idTests, idUsers, idTutor, questionBlurbs, questions, imageReferences, answers, submittedAnswers, submittedWorkings, logicalReasoningPoints, types, saveddates) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
     $stmt = mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: quiz.php?error=sqlerror");
          exit();
     } 

     mysqli_stmt_bind_param($stmt, "siisssssssss", $testid, $studentID, $uid, $questionBlurbs, $questions, $imagereferences, $answers, $submittedanswers, $submittedworkings, $logicalReasoningPoints, $type, $time);
     mysqli_stmt_execute($stmt);
     
     //close connection
     
} else {
     $sql = "INSERT INTO savedtests (idTests, idUsers, questionBlurbs, questions, imageReferences, answers, submittedAnswers, submittedWorkings, logicalReasoningPoints, types, saveddates) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
     $stmt = mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: quiz.php?error=sqlerror");
          exit();
     } 

     mysqli_stmt_bind_param($stmt, "sisssssssss", $testid, $uid, $questionBlurbs, $questions, $imagereferences, $answers, $submittedanswers, $submittedworkings, $logicalReasoningPoints, $type, $time);
     mysqli_stmt_execute($stmt);
     
     //close connection
     mysqli_stmt_close($stmt);
     mysqli_close($conn);
}
?>

