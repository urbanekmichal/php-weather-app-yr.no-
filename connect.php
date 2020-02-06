<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pocasi";
$spojeni = mysqli_connect($servername, $username, $password, $dbname);
if($spojeni === false){
    die("Error: Could not connect. ".$spojeni->connect_error);
}
mysqli_set_charset($spojeni, "utf8");
?>