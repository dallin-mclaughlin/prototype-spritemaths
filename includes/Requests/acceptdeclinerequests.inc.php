<?php
    
    session_start();
    require '../Database/dbh.inc.php';

    $userID = $_SESSION['userId'];

    //If button hasn't been pressed go back to previous page
    if(!(isset($_POST['accept-request'])||isset($_POST['decline-request']))) {
        header("Location: ../../Requests/requests.php");
        exit();
    }

    //If the request has been accepted
    if(isset($_POST['accept-request'])){
        //Set accepted to 1 in the requests table
        $idTutor = unserialize(base64_decode($_POST['accept-request']));
        $accepted = 1;
        $sql = "UPDATE tutorstudentrelations SET accepted = ? WHERE (idTutor,idStudent) = (?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../Requests/requests.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iii", $accepted, $idTutor, $userID);
        mysqli_stmt_execute($stmt);
    }

    //if the request has been declined
    if(isset($_POST['decline-request'])){
        $idTutor = unserialize(base64_decode($_POST['decline-request']));
        $sql = "DELETE FROM tutorstudentrelations WHERE (idTutor,idStudent) = (?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../Requests/requests.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ii", $idTutor, $userID);
        mysqli_stmt_execute($stmt);

    }

    header("Location: ../../Requests/requests.php");
    exit();
?>