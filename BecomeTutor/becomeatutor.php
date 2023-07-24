<?php
//The header for all screens
session_start();
require '../Header/header.php';
require '../includes/Database/dbh.inc.php';
require '../includes/testcodes.inc.php';

$studentsIDArray = [-1];
$studentsNameArray = ['--'];
$groupsNameArray = ['--'];
$groupsIDArray = [-1];

if(isset($_POST['name']) && $_POST['name']=='yes'){
    $sql = "UPDATE users SET isTutor = ? WHERE idUsers = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: /deltamaths/quiz.php?error=sqlerror");
        exit();
    } 
    $isTutorNew = 1;
    mysqli_stmt_bind_param($stmt, "ii", $isTutorNew, $_SESSION['userId']);
    mysqli_stmt_execute($stmt);
    
}


$sql = "SELECT isTutor,verifiedTutor,advertiseTutor,qualifications,profilepicReference FROM users WHERE idUsers=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$isTutor = $row['isTutor'];
$advertiseTutor = $row['advertiseTutor'];
$qualifications = $row['qualifications'];
$profilepicReference = $row['profilepicReference'];
$verifiedTutor = $row['verifiedTutor'];

//echo $isTutor;
$accepted=1;
$sql = "SELECT idStudent FROM tutorstudentrelations WHERE (idTutor,accepted)=(?,?);";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userId'], $accepted);
mysqli_stmt_execute($stmt);
$result1 = mysqli_stmt_get_result($stmt);
while($row1 = mysqli_fetch_assoc($result1)){
    array_push($studentsIDArray, $row1['idStudent']);
    $sql = "SELECT firstName,lastName FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $row1['idStudent']);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);
    while($row2 = mysqli_fetch_assoc($result2)){
        array_push($studentsNameArray, $row2['firstName'].' '.$row2['lastName']);
    }

}

$sql = "SELECT id,groupName FROM groups WHERE idTutor=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../../Requests/requests.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row = mysqli_fetch_assoc($result)){
    array_push($groupsIDArray,$row['id']);
    array_push($groupsNameArray,$row['groupName']);
}

print_r($studentsIDArray);
print_r($studentsNameArray);
//print_r($groupsIDArray);

//print_r($testCodeNames);



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Requests</title>
        <link rel="stylesheet" href="becomeatutor_style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
        
        $(document).ready(function() {
            var advertiseTutor = <?php echo $advertiseTutor; ?>;
            var isTutor = <?php echo $isTutor; ?>;

            if(isTutor){
                $('#tutorCheck').attr('checked',true);

            }

            if(advertiseTutor){
                $('#displayCheck').attr('checked',true);
                $('#text').attr('style','display:block');
            }

        })

        function confirmAction(){
            var tutorBox = document.getElementById("tutorCheck");
            var confirmAction = confirm("Are you sure you want to stop being a tutor? All your students will be lost.");
            if(confirmAction){
                update();
            } else {
                tutorBox.checked = true;
            }
        }

        function update() {
                // Get the checkbox
                var displayBox = document.getElementById("displayCheck");
                // Get the tutorCheckBox
                var tutorBox = document.getElementById("tutorCheck");
                // Get the output text
                var text = document.getElementById("text");

                // If the checkbox is checked, display the output text
                if (displayBox.checked == true){
                    text.style.display = "block";
                    updateAdvertisement(1);
                } else {
                    text.style.display = "none";
                    updateAdvertisement(0);
                }

                if(tutorBox.checked == false){
                    updateTutor(0);
                }
            }

            function updateAdvertisement(advertise)
            {

                $.post({
                    url: "../includes/BecomeATutor/updatetutorsettings.inc.php",
                    data: {advertisevalue: advertise},
                    success  :  function(data,xhr,req) {
                        if (req.status == 200) {
                            //alert('Successfull');
                            //window.location.replace("/deltamaths/HomeScreen/home.php");
                        } else {
                            //alert('Unsuccessful');
                        }
                    }

                })
            }

            function updateTutor(isTutor)
            {

                $.post({
                    url: "../includes/BecomeATutor/updatetutorsettings.inc.php",
                    data: {tutorvalue: isTutor},
                    success  :  function(data,xhr,req) {
                        if (req.status == 200) {
                            //alert('Successfull');
                            window.location.replace("becomeatutor.php");
                        } else {
                            //alert('Unsuccessful');
                        }
                    }

                })
            }
        </script>
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        This is the Become a Tutor page!
        <br>
        <br>
        Your ID is <?php echo $_SESSION['userId'] ?>
        <br>
        <div class="becometutor">
            <?php
                if(!$isTutor){
            ?>
            <form class="becometutor" method="post">
                <button input="submit" name="name" value="yes">Become a Tutor</button>
            </form>
            <?php
                } else {
            ?>
                    <p>You are a tutor<p>
                    <br>
                    <p>Do you wish to stop being a tutor?</p>
                    <label class="switch">
                    <input type="checkbox" id="tutorCheck" onclick="confirmAction()">
                    <span class="slider round"></span>
                    </label>
                    <br>
                    
                    <p>Do you wish to adverstise yourself as a tutor?</p>
                    <label class="switch">
                    <input type="checkbox" id="displayCheck" onclick="update()">
                    <span class="slider round"></span>
                    </label>
                    <p id="text" style="display:none">You are on display as a tutor!</p><br>
                    Include a statement saying your uploaded pictures are on display as a preview
                    <form action="../includes/BecomeATutor/uploadimage.inc.php" method="post" enctype="multipart/form-data">
                    Select image to upload for your profile picture:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="pic-submit">
                    </form>
                    <form action="../includes/BecomeATutor/uploadqualifications.inc.php" method="post" >
                    Write up your educational qualifications:
                    <textarea name="textToUpload" id="textToUpload"></textarea>
                    <input type="submit" value="Upload text" name="submit">
                    </form>
                    <form action="../includes/BecomeATutor/uploadimage.inc.php" method="post" enctype="multipart/form-data">
                    Select image to upload to prove your educational qualifications:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="qual-submit">
                    </form>
                    The Admins will approve your qualifications.
                    Here is a preview of what your advertising looks like on the Find a Tutor page.
                    Your advertising isn't shown on the Find a Tutor page because why would you want to be your own tutor lol
                    <br>
                    <form action="../includes/BecomeATutor/creategroup.inc.php" method="post" >
                    Enter a group name to be created:
                    <input type="text" name="group" id="group"></input>
                    <input type="submit" value="Create group" name="create-group">
                    </form>
                    <form action="../includes/BecomeATutor/assigntogroup.inc.php" method="post" >
                    <label for="students">Assign students to group</label>
                    <select id="students" name="students">
                        <?php 
                        for($i = 0; $i < count($studentsIDArray); $i++){
                            echo '<option value="'.$studentsIDArray[$i].'">'.$studentsNameArray[$i].'</option>';
                        }
                        ?>
                    </select>
                    <label for="groups">to</label>
                    <select id="groups" name="groups">
                        <?php 
                        for($i = 0; $i < count($groupsIDArray); $i++){
                            echo '<option value="'.$groupsIDArray[$i].'">'.$groupsNameArray[$i].'</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="assignstudent">
                    </form>
                    <!--create tests for students-->
                    <form action="../includes/BecomeATutor/createstudenttests.inc.php" method="post" >
                    <label for="students">Choose a student or a group</label>
                    <select id="students" name="students">
                        <?php 
                        for($i = 0; $i < count($studentsIDArray); $i++){
                            echo '<option value="'.$studentsIDArray[$i].'s'.'">'.$studentsNameArray[$i].'</option>';
                        }
                        for($i = 0; $i < count($groupsIDArray); $i++){
                            echo '<option value="'.$groupsIDArray[$i].'g'.'">'.$groupsNameArray[$i].'</option>';
                        }
                        ?>
                    </select>
                    <label for="tests">test:</label>
                    <select id="tests" name="tests">
                        <?php 
                        echo '<option>--Skills--</option>';
                        foreach($BasicSkills as $testCodeName){
                            echo '<option value="TestClasses/BASIC/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($YR9Skills as $testCodeName){
                            echo '<option value="TestClasses/YR9/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($YR10Skills as $testCodeName){
                            echo '<option value="TestClasses/YR10/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($NCEALVL1Skills as $testCodeName){
                            echo '<option value="TestClasses/NCEALVL1/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($NCEALVL2Skills as $testCodeName){
                            echo '<option value="TestClasses/NCEALVL2/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($NCEALVL3Skills as $testCodeName){
                            echo '<option value="TestClasses/NCEALVL3/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        }
                        foreach($ScholarshipSkills as $testCodeName){
                            echo '<option value="TestClasses/SCHOL/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        echo '<option>--Exams--</option>';
                        foreach($BasicExams as $testCodeName){
                            echo '<option value="ExamClasses/BASIC/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        foreach($YR9Exams as $testCodeName){
                            echo '<option value="ExamClasses/YR9/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        foreach($YR10Exams as $testCodeName){
                            echo '<option value="ExamClasses/YR10/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        foreach($NCEALVL1Exams as $testCodeName){
                            echo '<option value="ExamClasses/NCEALVL1/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        foreach($NCEALVL2Exams as $testCodeName){
                            echo '<option value="ExamClasses/NCEALVL2/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        foreach($NCEALVL3Exams as $testCodeName){
                            echo '<option value="ExamClasses/NCEALVL3/'.$testCodeName.'">'.str_replace('_',' ',$testCodeName).'</option>';
                        } 
                        ?>
                    </select>
                    <input type="submit" name="createtests">
                    </form>
                    <div id="tutor-advert">
                    <img id="profile-picture" src="../<?php echo $profilepicReference;?>" style="width:100px; height:auto">
                    </img>
                    <div id="text-advert">
                        <?php echo $qualifications;?>
                    </div>
                        <?php 
                            if($verifiedTutor){
                                echo "You are a verified Tutor";
                            } else {
                                echo "You have not yet been verified as a tutor.";
                            }
                        ?>
                    </div>
              <?php  }
            ?>

        </div>
    </body>
</html>

<!-- this hides the pending-requests class. I need to fix this! -->
<!-- if the user has no students then they can't create a group -->