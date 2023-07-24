<?php
    require 'includes/Database/dbh.inc.php';
    
    $sql = "SELECT * FROM savedtests WHERE idTests=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../HomeScreen/home.php?error=sqlerror");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "s", $testid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $questionBlurbs = unserialize(base64_decode($row['questionBlurbs']));
    $questions = unserialize(base64_decode($row['questions']));
    $answers = unserialize(base64_decode($row['answers']));
    $submittedanswers = unserialize(base64_decode($row['submittedAnswers']));
    $submittedworkings = unserialize(base64_decode($row['submittedWorkings']));
    $logicalReasoningPoints = unserialize($row['logicalReasoningPoints']);
    $imagereferences = unserialize(base64_decode($row['imageReferences']));
    $testTypes = $row['types'];
    $testTypes = str_replace("_"," ", $testTypes);
    $question_num = 0;
    $num_questions = count($questions);

    $sentToTutor = $row['sentToTutor'];
    $markedByTutor = $row['markedByTutor'];
    $idTutor = $row['idTutor'];

?>