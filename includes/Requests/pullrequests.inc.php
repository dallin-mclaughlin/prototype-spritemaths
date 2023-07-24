<?php 
    //session_start();
    require '../includes/Database/dbh.inc.php';
    /*
    $tutorIDs = [];
    $tutorNames = [];
    */

    
    $tutorIDs = [];
    $tutorNames = [];
    
    $userID = $_SESSION['userId'];
    echo $userID;
    $finalRequestSent=1;

    $sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND finalRequestSent=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $userID, $finalRequestSent);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)){
        array_push($tutorsIDs, $row['idTutor']);
    }

    for($i = 0; $i < count($tutorIDs); $i++){
        $sql = "SELECT firstName, lastName FROM users WHERE idUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../Requests/requests.php?error=sqlerror");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "i", $tutorIDs[$i]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $tutorFirstName = $row['firstName'];
        $tutorLastName = $row['lastName'];
        $tutorName = $tutorFirstName.' '.$tutorLastName;

        array_push($tutorNames, $tutorName);
    }


?>