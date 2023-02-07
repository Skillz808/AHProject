<?php

if (isset($_POST["submit"])){

    $currentEmail = $_POST["email"];
    $currentpwd = $_POST["currentpwd"];
    $newemail = $_POST["newemail"];
    $newpwd = $_POST["newpwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputProfile($currentEmail, $currentpwd, $newpwd, $newemail) !== false) {
        header("location: ../profile.php?error=emptyinput");
        exit();
    }    
    if (invalidEmail($currentEmail) !== false) {
        header("location: ../profile.php?error=invalidemail");
        exit();
    }  
    if (invalidEmail($newemail) !== false) {
        header("location: ../profile.php?error=invalidemail");
        exit();
    }  
    if (uidExists($conn, $newemail, $newemail) !== false) {
        header("location: ../profile.php?error=uidtaken");
        exit();
    } 

    updateUser($conn, $currentEmail, $currentpwd, $newemail, $newpwd);

}   
else {
    header("location: ../profile.php");
    exit();
}
?>