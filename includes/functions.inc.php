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

function emptyInputReview($name, $description, $rating) {
    $result;
    if (empty($name) || empty($description || empty($rating))) {
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
        $_SESSION["admin"] =  $uidExists["isAdmin"];
        header("location: ../index.php");
        exit();
    }
}

function updateUserPwd($conn, $newpwd) {
    $id = $_SESSION["userid"];
    $stmt = $conn->prepare("UPDATE users SET usersPwd = ? WHERE usersId = ?");
    if (!$stmt) {
        echo "Error in preparing the SQL query: " . $conn->error;
        return;
    }
    $hashedPwd = password_hash($newpwd, PASSWORD_DEFAULT);
    $result = $stmt->bind_param("si", $hashedPwd, $id);
    if (!$result) {
        echo "Error in binding the SQL parameters: " . $stmt->error;
        return;
    }
    $result = $stmt->execute();
    if (!$result) {
        echo "Error in executing the SQL query: " . $stmt->error;
        return;
    }
}

function updateUserEmail($conn, $newemail) {
    session_start();
    $id = $_SESSION["userid"];
    $stmt = $conn->prepare("UPDATE users SET usersEmail = ? WHERE usersId = ?");
    if (!$stmt) {
        echo "Error in preparing the SQL query: " . $conn->error;
        return;
    }
    $stmt->bind_param("si", $newemail, $id);
    $result = $stmt->execute();
    if (!$result) {
        echo "Error in executing the SQL query: " . $stmt->error;
        return;
    }
    echo "Number of rows affected: " . $stmt->affected_rows . "<br>";
}

function getProductInfo($conn, $productId) {
    $stmt = $conn->prepare("SELECT productName, productDescription, productPrice FROM product WHERE productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    $stmt->bind_result($productName, $productDescription, $productPrice);
    $stmt->fetch();

    return array(
        'name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice
    );
}

function executeQuery($conn, $query){
    $stmt = $query;
    $result = mysqli_query($conn, $stmt);
    if($result) { 
        return $result;
        exit(); 
      } else {
        header("location: ../adminpanel.php?error=stmtfailed");
        exit();
      }
    }

function countItems($conn, $table){
    $stmt = $conn->prepare("SELECT COUNT(1) FROM $table");
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    return $count;
}

function countItemsSearch($conn, $search){
    $search = "%$search%";
    $stmt = $conn->prepare("SELECT COUNT(1) FROM product WHERE productName LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    return $count;
}

function getProductInfoSearch($conn, $search, $offset) {
    $search = "%$search%";
    $stmt = $conn->prepare("SELECT productId, productName, productDescription, productPrice FROM product WHERE productName LIKE ? LIMIT 1 OFFSET ?");
    $stmt->bind_param("si", $search, $offset);
    $stmt->execute();

    $stmt->bind_result($id, $productName, $productDescription, $productPrice);
    $stmt->fetch();

    return array(
        'id' => $id,
        'name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice
    );
}
?>