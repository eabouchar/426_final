<?php
// Sessions: https://www.tutorialspoint.com/php/php_sessions.htm
ob_start();
session_start();

$timezome = date_default_timezone_set("America/New_York");
// $con = mysqli_connect("localhost", "root", "", "final_project");

// if(mysqli_connect_errno()) {
//     echo "Failed to connect " + mysqli_connect_errno();
// }


?>