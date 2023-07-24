<?php
//The header for all screens
session_start();
require '../Header/header.php';
require '../includes/Requests/pullrequests.inc.php';
require '../includes/Database/dbh.inc.php';

$tutorNameArray = [];
$tutorIDArray = [];
$verifiedTutorArray = [];
$tutorsNotLinkedYet = [];
$myTutors = [];
$interestedStudents = [];
$interestedStudentNames = [];
$tutorContactDetailIDs = [];
$tutorDetails = [];

$isTutor = 1;
$advertiseAsTutor = 1;

$studentId = $_SESSION['userId'];
$accepted = 0;
$acceptedForActualTutors = 1;
//Identify tutors who are actual tutors for this user
$sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND accepted=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii", $studentId, $acceptedForActualTutors);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)){
    array_push($myTutors, $row['idTutor']);
}
//Identify tutors who have requests sent to them from this user
$sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND accepted=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii", $studentId, $accepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)){
    array_push($tutorsNotLinkedYet, $row['idTutor']);
}

//GRAB ALL THE TUTORS
$sql = "SELECT idUsers,firstName,lastName,verifiedTutor FROM users WHERE isTutor=? AND advertiseTutor=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii", $isTutor, $advertiseAsTutor);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)) {
    $fullName = $row['firstName'].' '.$row['lastName'];
    if($row['idUsers'] != $_SESSION['userId'] ){ //Make sure your tutor advertisement isn't shown on this page
        array_push($tutorNameArray, $fullName);
        array_push($tutorIDArray, $row['idUsers']);
        array_push($verifiedTutorArray, $row['verifiedTutor']);
    }
}

//Grab the students who have requested you to be their tutor
$idUser = $_SESSION['userId'];
$sentDetails= $finalRequestSent = $accepted = 0;
$sql = "SELECT idStudent FROM tutorstudentrelations WHERE idTutor=? AND sentDetails=? AND finalRequestSent=? AND accepted=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}
mysqli_stmt_bind_param($stmt, "iiii", $idUser, $sentDetails, $finalRequestSent, $accepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)) {
    array_push($interestedStudents, $row['idStudent']);
}

for($i = 0; $i < count($interestedStudents); $i++){
    $sql = "SELECT firstName, lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $interestedStudents[$i]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $fullName = $row['firstName'].' '.$row['lastName'];
    array_push($interestedStudentNames, $fullName);
}

//Grab the contact details from the tutors who have agreed to send their contact details
$idUser = $_SESSION['userId'];
$finalRequestSent = $accepted = 0;
$sentDetails= 1;
$sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND sentDetails=? AND finalRequestSent=? AND accepted=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}
mysqli_stmt_bind_param($stmt, "iiii", $idUser, $sentDetails, $finalRequestSent, $accepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)) {
    array_push($tutorContactDetailIDs, $row['idTutor']);
}

for($i = 0; $i < count($tutorContactDetailIDs); $i++){
    $sql = "SELECT firstName, lastName, emailUsers FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $tutorContactDetailIDs[$i]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $fullNameEmail = $row['firstName'].' '.$row['lastName'].', '.$row['emailUsers'];
    array_push($tutorDetails, $fullNameEmail);
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Requests</title>
        <link rel="stylesheet" href="findatutor_style.css">
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        This is the Find a Tutor page!
        <br>
        This page is designed for students to find a reliable tutor based on the information given. Tutors have their qualifications verified by the administrator.
        <br>
        Once you have made contact with the tutor, the tutor will add you through the request page so that you become a registered student under their tutorship.
        <br>
        Your ID is <?php echo $userID ?>
        <br>
        <div class="tutors">
            
            <?php
                $output = '';
                if(!empty($tutorNameArray)){
                    $output .= '<form method ="post" action="../includes/FindATutor/sendinterest.inc.php">';
                    $output .= 'The Tutors are:  <br> ';
                    for($i = 0; $i < count($tutorNameArray); $i++){
                        if(($tutorIDArray[$i] != $_SESSION['userId'])&&!in_array($tutorIDArray[$i], $myTutors)){
                            $output .= $tutorNameArray[$i].' '.$tutorIDArray[$i];
                            if(!in_array($tutorIDArray[$i], $tutorsNotLinkedYet)){
                                $output .= '<button type = "submit" name = "tutor" value="'.base64_encode(serialize($tutorIDArray[$i])).'">';
                                $output .= 'Tell this tutor you are interested.';
                                if($verifiedTutorArray[$i]==1){
                                    $output .= 'This tutor is verified.';
                                } else {
                                    $output .= ' This tutor has not yet been verified.';
                                }
                                $output .= '</button>';
                            } else {
                                $output .= '<button type = "submit" name = "cancel" value="'.base64_encode(serialize($tutorIDArray[$i])).'">';
                                $output .= 'Cancel Request.';
                                $output .= '</button>';
                            }
                        }
                    }
                        $output .= '</form>';
                }
                echo $output;
                
                //print_r($myTutors);
                //print_r($interestedStudentNames);

                $outputTutor = '';
                $outputTutor = '__________________________________________________';
                echo $outputTutor;
                
            ?>
            
        </div>
        <div class="student-requests">
            
            <?php
            //Let's say another user has requested you to be their tutor. Here goes!
                $output = '';
                if(!empty($interestedStudents)){
                    $output .= '<form method ="post" action="../includes/FindATutor/sendcontactdetails.inc.php">';
                    $output .= 'These users are interested in your tutorship:  <br> ';
                    for($i = 0; $i < count($interestedStudents); $i++){
                        $output .= $interestedStudentNames[$i];
                        $output .= '<button type = "submit" name = "student" value="'.base64_encode(serialize($interestedStudents[$i])).'">';
                        $output .= 'Send your contact details to this student.';
                        $output .= '</button>';
                    }
                }
                echo $output;
            ?>
        </div>
        <div class="tutor-details">
            
            <?php
            //Let's say another user has requested you to be their tutor. Here goes!
                $output = '';
                if(!empty($tutorContactDetailIDs)){
                    $output .= '<p>';
                    $output .= 'Here are the tutor contact details:  <br> ';
                    for($i = 0; $i < count($tutorContactDetailIDs); $i++){
                        $output .= ($i+1).'. ';
                        $output .= $tutorDetails[$i];
                        $output .= '<br>';
                    }
                    echo '<p>';
                }

                echo $output;
            ?>
        </div>
            
    </body>
</html>

<!-- this hides the pending-requests class. I need to fix this! -->