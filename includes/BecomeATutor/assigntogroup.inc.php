<?php
session_start();
require '../Database/dbh.inc.php';

if(!isset($_POST['assignstudent'])){
    header("Location: ../../BecomeTutor/becomeatutor.php?message=first");
    exit();
}

if($_POST['groups']=='--'||$_POST['students']=='--'){
  header("Location: ../../BecomeTutor/becomeatutor.php?message=nogroup");
  exit();
}

$sql = "UPDATE users SET idGroup = ? WHERE idUsers = ?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii",$_POST['groups'], $_POST['students']);
mysqli_stmt_execute($stmt);


header("Location: ../../BecomeTutor/becomeatutor.php?message=studentassignedtogroup");
exit();
//first check if there exists references in the database and if there are delete the files first and then add the pictures.
//first check if there is a file to upload otherwise if not then go back to the previous page

?>
