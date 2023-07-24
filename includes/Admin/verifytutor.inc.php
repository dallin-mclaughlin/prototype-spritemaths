<?php
require '../Database/dbh.inc.php';
if(isset($_POST['verifiedvalue'])&&isset($_POST['useridvalue'])){
    $verifiedValue = $_POST['verifiedvalue'];
    $userID = $_POST['useridvalue'];
    
    $sql = "UPDATE users SET verifiedTutor = ? WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $verifiedValue, $userID);
    mysqli_stmt_execute($stmt);
}
?>