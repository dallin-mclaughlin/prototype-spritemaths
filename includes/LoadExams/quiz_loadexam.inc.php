<?php
    require '../includes/Database/dbh.inc.php';
    $examId = $_GET['exam'];

    $sql = "SELECT * FROM savedexams WHERE idExams=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $examId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $questions = unserialize(base64_decode($row['questions']));
    $answers = unserialize(base64_decode($row['answers']));
    $submittedanswers = unserialize(base64_decode($row['submittedAnswers']));
    $submittedworkings = unserialize(base64_decode($row['submittedWorkings']));
    $imagereferences = unserialize(base64_decode($row['imageReferences']));
    $examTypes = $row['types'];
    $examTypes = str_replace("_"," ", $examTypes);
    $question_num = 0;
    $num_questions = count($questions);

?> 