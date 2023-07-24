<?php
//The header for all screens
session_start();
require '../includes/Database/dbh.inc.php';
require '../Header/header.php';

$tutorsIDs = [];
$tutorNames = [];

$myTutors = [];
$myTutorNames = [];

$myStudents = [];
$myStudentNames = [];


$userID = $_SESSION['userId'];
$finalRequestSent=1;
$accepted=0;
//Get requests
$sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND finalRequestSent=? AND accepted =?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "iii", $userID, $finalRequestSent,$accepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result)){
    array_push($tutorsIDs, $row['idTutor']);
}

for($i = 0; $i < count($tutorsIDs); $i++){
    $sql = "SELECT firstName, lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "i", $tutorsIDs[$i]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $tutorFirstName = $row['firstName'];
    $tutorLastName = $row['lastName'];
    $tutorName = $tutorFirstName.' '.$tutorLastName;

    array_push($tutorNames, $tutorName);
}

$myTutorAccepted = 1;
//get your tutors
$sql = "SELECT idTutor FROM tutorstudentrelations WHERE idStudent=? AND finalRequestSent=? AND accepted =?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "iii", $userID, $finalRequestSent,$myTutorAccepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result)){
    array_push($myTutors, $row['idTutor']);
}

for($i = 0; $i < count($myTutors); $i++){
    $sql = "SELECT firstName, lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "i", $myTutors[$i]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $tutorFirstName = $row['firstName'];
    $tutorLastName = $row['lastName'];
    $tutorName = $tutorFirstName.' '.$tutorLastName;

    array_push($myTutorNames, $tutorName);
}

$myStudentAccepted = 1;
//get your students
$sql = "SELECT idStudent FROM tutorstudentrelations WHERE idTutor=? AND finalRequestSent=? AND accepted =?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "iii", $userID, $finalRequestSent,$myStudentAccepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result)){
    array_push($myStudents, $row['idStudent']);
}

for($i = 0; $i < count($myStudents); $i++){
    $sql = "SELECT firstName, lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "i", $myStudents[$i]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $studentFirstName = $row['firstName'];
    $studentLastName = $row['lastName'];
    $studentName = $studentFirstName.' '.$studentLastName;

    array_push($myStudentNames, $studentName);
}

print_r($myStudents);

/* $accepted=1;
$sql = "SELECT idStudent FROM tutorstudentrelations WHERE (idTutor,accepted)=(?,?);";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userId'], $accepted);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)){
    echo $row['idStudent'];
    array_push($studentsIDArray, $row['idStudent']);
    $sql = "SELECT firstName,lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $row['idStudent']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        array_push($studentsNameArray, $row['firstName'].' '.$row['lastName']);
    }

} */

//Is this user a tutor?
$sql = "SELECT isTutor FROM users WHERE idUsers=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$isTutor = $row['isTutor'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Requests</title>
        <link rel="stylesheet" href="requests_style.css">
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        This is the Request page!
        <br>
        This page is designed for tutors that already have a client base to quickly add their current students as students on the website.
        <br>
        Also here tutors can enter in the details of their newly found interested clients to validate their tutor student relationship.
        <br>
        Students also accept requests from tutors.
        <br>
        What would happen if you typed in your own id and first name? Make it so it cannot happen!
        <br>
        Your ID is <?php echo $userID ?>
        <br>
        <div class= "pending-requests">
            <form class = "pendingrequests" action="../includes/Requests/acceptdeclinerequests.inc.php" autocomplete="off" method="post">
            <?php
            for($i = 0; $i < count($tutorsIDs); $i++){
                echo "<p>".$tutorNames[$i]." has sent you a tutoring request.</p>";
                echo '<button id = "accept" class = "acceptButton" name = "accept-request" value = "'.base64_encode(serialize($tutorsIDs[$i])).'" >Accept</button>';
                echo '<button id = "decline" class = "declineButton" name = "decline-request" value = "'.base64_encode(serialize($tutorsIDs[$i])).'">Decline</button>';
            }  
            ?>
            </form>
        </div>
        <?php if($isTutor){ ?>
        <div class="requests">
            <form class = "sendrequests" action="../includes/Requests/sendrequests.inc.php" autocomplete="off" method="post">
                <div class="send-requests">
                    <input type="text" placeholder="First Name" name="fname" required>
                    <input type="text" placeholder="Student ID" name="studentid" required>
                    <button id = "send" class="sendButton" name ="send-request">Send</button>
                </div>
            </form>    
            <br>
            <br>
        </div>
        <div class="students">
            <?php 
            if(!empty($myStudentNames)){
                $output = 'Your students are: ';
                foreach($myStudentNames as $myStudentName){
                    $output .= $myStudentName.' ';
                }
                echo $output;
            }
            ?>
        </div>
        <?php } ?>
        <div class="teachers">
            <?php 
            if(!empty($myTutorNames)){
                $output = 'Your tutors are: ';
                foreach($myTutorNames as $myTutorName){
                    $output .= $myTutorName.' ';
                }
                echo $output;
            }
            ?>
        </div>
    </body>
</html>

<!-- this hides the pending-requests class. I need to fix this! -->