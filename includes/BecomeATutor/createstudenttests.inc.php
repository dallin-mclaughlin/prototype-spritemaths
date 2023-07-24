<?php
session_start();
require '../Database/dbh.inc.php';
require '../testcodes.inc.php';

if(!isset($_POST['createtests'])){
    header("Location: ../../BecomeTutor/becomeatutor.php");
    exit();
}

if(substr($_POST['tests'],0,2)=="--"){
    header("Location: ../../BecomeTutor/becomeatutor.php?message=notest");
    exit();
}

if($_POST['students']=='-1s'||$_POST['students']=='-1g'){
  header("Location: ../../BecomeTutor/becomeatutor.php?message=noassignedpersons");
  exit();
}

//check if it is a group first
if(substr($_POST['students'],-1)=='s'){
    $createdByTutor = 1;
    $studentID = substr($_POST['students'],0,-1);
    //create a test for the student including the tutorid
    $newtest = $_POST['tests'];
    if(substr($newtest,0,1)=='T'){
        require '../TestManager/test_manager.inc.php';
    } else if(substr($newtest,0,1)=='E'){
        require '../TestManager/exam_manager.inc.php';
    }
    require '../SavingTests/savenewtest.inc.php';

} else if (substr($_POST['students'],-1)=='g'){
    $createdByTutor = 1;
    $groupID = substr($_POST['students'],0,-1);
    //get a list of all the studentIds that are within this group and create a separate test for each of them including the tutorid
    $sql = "SELECT idUsers FROM users WHERE idGroup=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../HomeScreen/home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $groupID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $newtest = $_POST['tests'];
        $studentID = $row['idUsers'];
        if(substr($newtest,0,1)=='T'){
            require '../TestManager/test_manager.inc.php';
        } else if(substr($newtest,0,1)=='E'){
            require '../TestManager/exam_manager.inc.php';
        }
        require '../SavingTests/savenewtest.inc.php';
    }
    //I need to fix the text file creation destination in the question classes. all else is good!
    // perhaps I can use global variables. Yeah! To say if createdByTutor then this is the new destinaation

}

//if not a group then it must be an individual



header("Location: ../../BecomeTutor/becomeatutor.php?message=success");
exit();

?>
