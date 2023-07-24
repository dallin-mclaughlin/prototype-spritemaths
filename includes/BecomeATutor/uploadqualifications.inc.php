<?php
session_start();
require '../Database/dbh.inc.php';

if(!isset($_POST['submit'])){
    header('Location: ../../BecomeTutor/becomeatutor.php');
    exit();
}
$verifiedTutor = 0;

$sql = "UPDATE users SET verifiedTutor = ?, qualifications = ? WHERE idUsers = ?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../HomeScreen/home.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "isi",$verifiedTutor, $_POST['textToUpload'], $_SESSION['userId']);
mysqli_stmt_execute($stmt);

header('Location: ../../BecomeTutor/becomeatutor.php?message=success');
exit();

?>