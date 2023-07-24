<?php 
    require 'includes/Database/dbh.inc.php';
    //tests that have been created by user or created by the tutor and sent to the student
    $test_IDs = [];
    $test_types = [];
    $test_saveddates = [];
    $test_subAnswers = [];

    //tests that have been sent to the tutor for marking
    $tutortest_IDs = [];
    $tutortest_types = [];
    $tutortest_saveddates = [];
    $tutortest_subAnswers = [];

    //tests that have been marked by the tutor that the student can now view
    $markedstudenttest_IDs = [];
    $markedstudenttest_types = [];
    $markedstudenttest_saveddates = [];
    $markedstudenttest_subAnswers = [];
    

    $userID = $_SESSION['userId'];
    $sentToTutor=0;

    $sql = "SELECT idTests,submittedAnswers,types,saveddates FROM savedtests 
                WHERE idUsers=? AND sentToTutor=?  ORDER BY saveddates DESC";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $userID, $sentToTutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {
        array_push($test_IDs, $row['idTests']);
        array_push($test_types, $row['types']);
        array_push($test_saveddates, $row['saveddates']);
        array_push($test_subAnswers, unserialize(base64_decode($row['submittedAnswers'])));
    }

    $sentToTutor=1;
    $markedByTutor=0;
    $sql = "SELECT idTests,submittedAnswers,types,saveddates FROM savedtests 
                WHERE idTutor=? AND sentToTutor=? AND markedByTutor=? ORDER BY saveddates DESC";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iii", $userID, $sentToTutor, $markedByTutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {
        array_push($tutortest_IDs, $row['idTests']);
        array_push($tutortest_types, $row['types']);
        array_push($tutortest_saveddates, $row['saveddates']);
        array_push($tutortest_subAnswers, unserialize(base64_decode($row['submittedAnswers'])));
    }

    $sentToTutor=1;
    $markedByTutor=1;
    $sql = "SELECT idTests,submittedAnswers,types,saveddates FROM savedtests 
                WHERE idUsers=? AND sentToTutor=? AND markedByTutor=? ORDER BY saveddates DESC";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iii", $userID, $sentToTutor, $markedByTutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {
        array_push($markedstudenttest_IDs, $row['idTests']);
        array_push($markedstudenttest_types, $row['types']);
        array_push($markedstudenttest_saveddates, $row['saveddates']);
        array_push($markedstudenttest_subAnswers, unserialize(base64_decode($row['submittedAnswers'])));
    }

?>