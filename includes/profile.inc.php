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

    if (!empty($newemail) && !empty($newpwd)) { //update both email and password if both are not empty
        updateUserEmail($conn, $newemail);
        updateUserPwd($conn, $newpwd);
    }
    else if (!empty($newemail)) { //update only email if it is not empty
        updateUserEmail($conn, $newemail);
    }
    else if (!empty($newpwd)) { //update only password if it is not empty
        updateUserPwd($conn, $newpwd);
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