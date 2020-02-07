<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pocasi";
$connection = mysqli_connect($servername, $username, $password, $dbname);
if($connection === false){
    die("Error: Could not connect. ".$connection->connect_error);
}
mysqli_set_charset($connection, "utf8");
?>