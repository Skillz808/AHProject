<?php

function emptyInputSignup($username, $email, $pwd, $pwdRepeat) {
    $result;
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $pwd) {
    $sql = "INSERT INTO users (usersUid, usersEmail, usersPwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); #hehe you cant hack me

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputProfile($currentpwd, $newpwd, $newemail) {
    $result;
    if (empty($currentpwd) || (empty($newpwd) || empty($newemail))) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=incorrectlogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false){
        header("location: ../login.php?error=incorrectpwd");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        $_SESSION["userid"] =  $uidExists["usersId"];
        $_SESSION["useruid"] =  $uidExists["usersUid"];
        header("location: ../index.php");
        exit();
    }
}

function updateUser($conn, $currentEmail, $currentpwd, $newpwd, $newemail){ //this is going to be horrible
    $uidExists = uidExists($conn, $currentEmail, $currentEmail);

    if ($uidExists === false) {
        header("location: ../profile.php?error=incorrectlogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($currentpwd, $pwdHashed);

    if ($checkPwd === false){
        header("location: ../profile.php?error=incorrectpwd");
        exit();
    }
    else if ($checkPwd === true){
            if (empty($newemail) == true) {
                $sql = "UPDATE users (usersPwd) VALUES (?);";
            }
            else if (empty($newpwd) == true){
                $sql = "UPDATE users (usersEmail) VALUES (?);";
            }
            else {
                $sql = "UPDATE users (usersEmail, usersPwd) VALUES (?,?);";
            }
            
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../signup.php?error=stmtfailed");
                exit();
            }
        
            $hashedPwd = password_hash($newpwd, PASSWORD_DEFAULT); #hehe you still cant hack me
        
            if (empty($newemail) == true) {
                mysqli_stmt_bind_param($stmt, "s", $hashedPwd);
            }
            else if (empty($newpwd) == true){
                mysqli_stmt_bind_param($stmt, "s", $newemail);
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $newemail, $hashedPwd);
            }

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            session_start();
            session_unset();
            session_destroy();
            
            header("location: ../index.php");
            exit();
        }
    }
?>