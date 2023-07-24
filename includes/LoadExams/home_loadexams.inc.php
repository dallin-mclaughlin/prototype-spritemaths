<?php 
    require '../includes/Database/dbh.inc.php';
    $exam_IDs = [];
    $exam_types = [];
    $exam_saveddates = [];
    $exam_subAnswers = [];
    $userID = $_SESSION['userId'];

    $sql = "SELECT idUsers,idExams,submittedAnswers,types,saveddates FROM savedexams 
                WHERE idUsers=? ORDER BY saveddates DESC";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {
        array_push($exam_IDs, $row['idExams']);
        array_push($exam_types, $row['types']);
        array_push($exam_saveddates, $row['saveddates']);
        array_push($exam_subAnswers, unserialize(base64_decode($row['submittedAnswers'])));
    }

?>