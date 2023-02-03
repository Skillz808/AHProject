<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "ahproject";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . msqli_connect_error());
}
?>