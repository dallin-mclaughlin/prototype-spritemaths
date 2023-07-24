<!-- The php code that sets up a connection with the mysql database system -->
<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "deltamaths";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>


$servername = "localhost";
$dBUsername = "u465701908_spritemaths";
$dBPassword = "mathisCool153";
$dBName = "u465701908_spritemaths";  u465701908_spritemaths