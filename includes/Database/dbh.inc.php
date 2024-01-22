<!-- The php code that sets up a connection with the mysql database system -->
<?php

$servername = "";
$dBUsername = "";
$dBPassword = "";
$dBName = "";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>


$servername = "";
$dBUsername = "";
$dBPassword = "";
$dBName = "";  
