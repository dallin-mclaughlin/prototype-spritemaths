<?php
session_start();
unset($_SESSION['userId']);
unset($_SESSION['emailId']);
unset($_SESSION['testID']);
unset($_SESSION['fname']);
unset($_SESSION['lname']);
unset($_SESSION['t']);

header("Location: ../../index.php?logout=success");
?>