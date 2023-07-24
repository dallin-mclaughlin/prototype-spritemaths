<?php
require '../Database/dbh.inc.php';
if(isset($_POST['deleteid'])){

    $userID = $_POST['deleteid'];
    //echo $userID;
    
    $sql = "DELETE FROM  tutorstudentrelations WHERE idTutor = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM  tutorstudentrelations WHERE idStudent = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM savedtests WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM  savedtests WHERE idTutor = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM  groups WHERE idTutor = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM users WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
}

//header("Location: ../../HomeScreen/adminhome.php");
//exit();
//look into DELETE CASCADE things
?>