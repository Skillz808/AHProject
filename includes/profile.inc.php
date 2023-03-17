<?php

if (isset($_POST["submit"])){

    $newemail = $_POST["newemail"];
    $newpwd = $_POST["newpwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
 
    if (invalidEmail($newemail) !== false) {
        header("location: ../profile.php?error=invalidemail");
        exit();
    }  
    if (uidExists($conn, $newemail, $newemail) !== false) {
        header("location: ../profile.php?error=uidtaken");
        exit();
    } 

    session_start();

    if (!empty($newpwd)) {
        updateUserPwd($conn, $newpwd);
    }
    else if (!empty($newemail)) {
        updateUserEmail($conn, $newemail);
    }
    else{
        updateUserPwd($conn, $newpwd);
        updateUserEmail($conn, $newemail);
    }

    session_unset();
    session_destroy();
    header("location: ../index.php");
}   
else {
    header("location: ../profile.php");
    exit();
}
?>