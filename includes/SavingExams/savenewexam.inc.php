<?php
require '../../Database/dbh.inc.php';

$questions = base64_encode(serialize($questions));
$answers = base64_encode(serialize($answers));
$submittedanswers = base64_encode(serialize($submittedanswers));
$submittedworkings = base64_encode(serialize($submittedWorkings));
$imagereferences = base64_encode(serialize($imagereferences));
$uid = $_SESSION['userId'];

$sql = "INSERT INTO savedexams (idExams, idUsers, questions, imageReferences, answers, submittedAnswers, submittedWorkings, types, saveddates) VALUES (?,?,?,?,?,?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
     header("Location: ../../../QuizScreen/quiz.php?error=sqlerror");
     exit();
} 

mysqli_stmt_bind_param($stmt, "sisssssss", $examid, $uid, $questions, $imagereferences, $answers, $submittedanswers, $submittedworkings, $type, $time);
mysqli_stmt_execute($stmt);
    
//close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: ../../../QuizScreen/quiz.php?exam='.$examid);

?>

