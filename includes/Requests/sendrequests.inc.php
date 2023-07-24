<!-- The php code that allows a user to login by connecting to the database and checks for possible errors -->

<?php
session_start();
//make sure that this page is accessed through the send-request button
if(!isset($_POST['send-request'])) {
    header("Location: ../../Requests/requests.php");
    exit();
}

//include data from database handler page
require '../Database/dbh.inc.php';
    
//retrieve data from user input
$fname = $_POST['fname'];
$studentID = $_POST['studentid'];
$tutorID = $_SESSION['userId'];

//make sure that the First name and Student ID have nonempty fields
if(empty($fname) || empty($studentID)) {
    header("Location: ../../Requests/requests.php?error=emptyfields");
    exit();
} 

//grab the first name of the tutor and then make sure the tutor hasn't requested themselves
$sql = "SELECT firstName FROM users WHERE idUsers = ?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}
mysqli_stmt_bind_param($stmt, "i", $tutorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$tutorFName = $row['firstName'];

if($fname == $tutorFName){
    header("Location: ../../Requests/requests.php?message=cantrequestyourself");
    exit();
}

//check if username and id match the stored id or username
$sql = "SELECT firstName FROM users WHERE idUsers = ?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}
mysqli_stmt_bind_param($stmt, "i", $studentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
if(strtolower($fname) != strtolower($row['firstName'])){
    header("Location: ../../Requests/requests.php?error=eitherpasswordorusernameincorrect");
    exit();
}

        
$sql = "SELECT * FROM tutorstudentrelations WHERE (idTutor,idStudent)=(?,?)";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}            

mysqli_stmt_bind_param($stmt, "ii", $tutorID, $studentID);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
if($resultCheck==0) {
    $sentDetails = 1;
    $finalRequestSent = 1;
    $sql = "INSERT INTO tutorstudentrelations (idTutor, idStudent,sentDetails,finalRequestSent) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'hey3';
        exit();
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }  


    //if no duplicates exist insert user information including hashed password into database table called users
    mysqli_stmt_bind_param($stmt, "iiii", $tutorID, $studentID, $sentDetails, $finalRequestSent);
    mysqli_stmt_execute($stmt);
    header("Location: ../../Requests/requests.php?message=allgoodg");
    exit();
} else {
    $finalRequestSent = 1;
    $sql = "UPDATE tutorstudentrelations SET finalRequestSent = ? WHERE (idTutor,idStudent) = (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iii", $finalRequestSent, $tutorID, $studentID);
    mysqli_stmt_execute($stmt);

    header("Location: ../../Requests/requests.php?message=allgoodg");
    exit();
}

                
?>