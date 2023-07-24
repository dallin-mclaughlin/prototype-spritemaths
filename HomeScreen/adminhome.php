<?php
    session_start();
 
    //The header for all screens
    require '../Header/adminheader.php';
    require '../includes/Database/dbh.inc.php';

    $tutorsNameArray = [];
    $tutorsIDArray = [];
    $tutorsQualificationsArray = [];
    $tutorsVerified = [];
    $tutorsQualificationsReferenceArray = [];

    $studentsIDArray = [];
    $studentsNameArray = [];

    $isTutor=1;
    $sql = "SELECT * FROM users WHERE isTutor=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../LoginScreen/loginscreen.php?error=sqlerror");
        exit();
    }            
    
    
    mysqli_stmt_bind_param($stmt, "i", $isTutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        array_push($tutorsNameArray, $row['firstName'].' '.$row['lastName']);
        array_push($tutorsIDArray, $row['idUsers']);
        array_push($tutorsQualificationsArray, $row['qualifications']);
        array_push($tutorsVerified, $row['verifiedTutor']);
        array_push($tutorsQualificationsReferenceArray, $row['qualificationsReference']);
    }

    $isTutor=0;
    $sql = "SELECT * FROM users WHERE isTutor=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../LoginScreen/loginscreen.php?error=sqlerror");
        exit();
    }            
    
    
    mysqli_stmt_bind_param($stmt, "i", $isTutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        array_push($studentsNameArray, $row['firstName'].' '.$row['lastName']);
        array_push($studentsIDArray, $row['idUsers']);
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>deltamaths</title>
        <link rel="stylesheet" href="home_style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>

            function confirmDelete(id)
            {
                var confirmDelete = confirm("Are you sure you want to delete this account?");
                if(confirmDelete){
                    deleteAccount(id);
                }
            }


            function update(id){
                var check = document.getElementById("check"+id);

                if(check.checked==true){
                    updateTutorVerification(1,id);
                } else {
                    updateTutorVerification(0,id);
                }

            }
            
            function deleteAccount(id){
                $.post({
                    url: "../includes/Admin/deleteaccount.inc.php",
                    data: {deleteid: id},
                    success  :  function(data,xhr,req) {
                        if (req.status == 200) {
                            //alert('Successful');
                            window.location.replace("adminhome.php");
                        } else {
                            //alert('Unsuccessful');
                        }
                    }

                })
            }

            function updateTutorVerification(verified,userid){
                $.post({
                    url: "../includes/Admin/verifytutor.inc.php",
                    data: {verifiedvalue: verified,
                            useridvalue: userid},
                    success  :  function(data,xhr,req) {
                        if (req.status == 200) {
                            //alert('Successful');
                            //window.location.replace("adminhome.php");
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
        This is the Admin home page!
        <br>
        <br>
        <div class="accounts-window">
            <div class="tutoraccounts">
                <table border = "1px solid black" style="width:100%">
                    <tbody>
                <?php
                    $output = '';
                    $output = 'The tutors';
                    $output .='<tr>';
                            $output .='<th>';
                            $output .= 'ID';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Name';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Advertisement Blurb';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Qualifications Upload';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Check to verify';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Remove Account';
                            $output .='</th>';
                        $output .='</tr>';
                    for($i=0; $i<count($tutorsIDArray);$i++){
                        $output .='<tr>';
                        $output .='<td>';
                                $output .='<label>'.$tutorsIDArray[$i].'</label>';
                            $output .='</td>';
                            $output .='<td>';
                                $output .='<label>'.$tutorsNameArray[$i].'</label>';
                            $output .='</td>';
                            $output .='<td>';
                                $output .='<label>'.$tutorsQualificationsArray[$i].'</label>';
                            $output .='</td>';
                            if($tutorsQualificationsReferenceArray[$i]!=''){
                                $output .='<td>';
                                    $output .='<img src="../'.$tutorsQualificationsReferenceArray[$i].'" width ="100"></img>';
                                $output .='</td>';
                            } else {
                                $output .='<td>';
                                    $output .='<label>Nothing is uploaded</label>';
                                $output .='</td>';
                            }
                            $output .='<td>';
                                if($tutorsVerified[$i]){
                                    $output .='<input id="check'.$tutorsIDArray[$i].'" type="checkbox" checked ="true" onclick="update('.$tutorsIDArray[$i].')">';
                                } else {
                                    $output .= '<input id="check'.$tutorsIDArray[$i].'" type="checkbox" onclick="update('.$tutorsIDArray[$i].')">';
                                }
                            $output .='</td>';
                            $output .='<td>';
                                $output .= '<button onclick="confirmDelete('.$tutorsIDArray[$i].')">Remove Account</button>';
                            $output .='</td>';
                        $output .='</tr>';
                            }
                    echo $output;
                ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
            <div class="studentaccounts">
                <table border = "1px solid black" style="width:100%">
                    <tbody>
                <?php
                    $output = '';
                    $output = 'The students';
                    $output .='<tr>';
                            $output .='<th>';
                            $output .= 'ID';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Name';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= '             ';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= '              ';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= '             ';
                            $output .='</th>';
                            $output .='<th>';
                            $output .= 'Remove Account';
                            $output .='</th>';
                        $output .='</tr>';
                    for($i=0; $i<count($studentsIDArray);$i++){
                        $output .='<tr>';
                        $output .='<td>';
                                $output .='<label>'.$studentsIDArray[$i].'</label>';
                            $output .='</td>';
                            $output .='<td>';
                                $output .='<label>'.$studentsNameArray[$i].'</label>';
                            $output .='</td>';
                            $output .='<td>';
                            $output .= '';
                            $output .='</td>';
                            $output .='<td>';
                            $output .= '';
                            $output .='</td>';
                            $output .='<td>';
                            $output .= '';
                            $output .='</td>';
                            $output .='<td>';
                                $output .= '<button onclick="confirmDelete('.$studentsIDArray[$i].')">Remove Account</button>';
                            $output .='</td>';
                        $output .='</tr>';
                    }
                    echo $output;
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<!-- to center align all the text: in css; table, td, th {border: 1px solid black; width: 300px;}
