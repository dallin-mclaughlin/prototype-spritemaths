<?php
session_start();
require '../Database/dbh.inc.php';

if(empty($_FILES["fileToUpload"]["name"])){
  header("Location: ../../BecomeTutor/becomeatutor.php?message=nofilechosen");
  exit();
}

$sql = "SELECT profilepicReference,qualificationsReference FROM users WHERE idUsers=?";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../../LoginScreen/loginscreen.php?error=sqlerror");
    exit();
}            

mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);


$target_dir = "";
$target_dir_dtb = "";
if(isset($_POST['qual-submit'])){
  $target_dir = "../../images/qualificationVerification/";
  $target_dir_dtb = "images/qualificationVerification/";
  if($row['qualificationsReference']!=''){
    unlink('../../'.$row['qualificationsReference']);
  }
} else if ($_POST['pic-submit']){
  $target_dir = "../../images/tutorProfiles/";
  $target_dir_dtb = "images/tutorProfiles/";
  if($row['profilepicReference']!=''){
    unlink('../../'.$row['profilepicReference']);
  }
}
$target_file = $target_dir . $_SESSION['userId'] . '_' . basename($_FILES["fileToUpload"]["name"]);
$target_file_dtb = $target_dir_dtb . $_SESSION['userId'] . '_' . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["qual-submit"])||isset($_POST['pic-submit'])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
//Just need to include 

if(isset($_POST['pic-submit'])){
  $sql = "UPDATE users SET profilepicReference = ? WHERE idUsers=?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../../Requests/requests.php?error=sqlerror");
      exit();
  }

  mysqli_stmt_bind_param($stmt, "si",$target_file_dtb, $_SESSION['userId']);
  mysqli_stmt_execute($stmt);
} else if (isset($_POST['qual-submit'])){
  $sql = "UPDATE users SET qualificationsReference = ? WHERE idUsers=?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../../Requests/requests.php?error=sqlerror");
      exit();
  }

  mysqli_stmt_bind_param($stmt, "si",$target_file_dtb, $_SESSION['userId']);
  mysqli_stmt_execute($stmt);
}

header("Location: ../../BecomeTutor/becomeatutor.php?message=imageuploaded");
exit();
//first check if there exists references in the database and if there are delete the files first and then add the pictures.
//first check if there is a file to upload otherwise if not then go back to the previous page

?>
