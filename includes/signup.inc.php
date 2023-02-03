<?php

if (isset($_POST["submit"])){
    
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($username, $email, $pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }    
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }  
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }  
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=pwddonotmatch");
        exit();
    } 
    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=uidtaken");
        exit();
    } 

    createUser($conn, $username, $email, $pwd);
}   
else {
    header("location: ../signup.php");
    exit();
}
?>