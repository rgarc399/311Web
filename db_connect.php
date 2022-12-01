<?php
/* Database connection start */
$dhost = "localhost";
    $dbuser = "root";
    $dbPassword = "";
    $db = "311data";


/**/
$conn = mysqli_connect($dhost, $dbuser, $dbPassword, $db) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>