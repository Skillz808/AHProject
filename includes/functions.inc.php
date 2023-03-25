<?php

function emptyInputSignup($username, $email, $pwd, $pwdRepeat) { //returns true if any of the inputs are empty
    $result;
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) { //returns true if the username is invalid
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) { //returns true if the email is invalid
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) { //returns true if the passwords do not match
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) { //returns true if the username or email already exists
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

function createUser($conn, $username, $email, $pwd) { //creates a new user
    $sql = "INSERT INTO users (usersUid, usersEmail, usersPwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); //hashes the password with a salt for security

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) { //returns true if any of the inputs are empty
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputReview($name, $description, $rating) { //returns true if any of the inputs are empty
    $result;
    if (empty($name) || empty($description || empty($rating))) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){ //logs in the user
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

function updateUserPwd($conn, $newpwd) { //updates the user's password
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

function updateUserEmail($conn, $newemail) { //updates the user's email
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

function getProductInfo($conn, $productId) { //gets the product info from the database
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

function executeQuery($conn, $query){ //executes a query
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

function countItems($conn, $table){ //counts the number of items in a table
    $stmt = $conn->prepare("SELECT COUNT(1) FROM $table");
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    return $count;
}

function countItemsSearch($conn, $search){ //counts the number of items in a table
    $search = "%$search%";
    $stmt = $conn->prepare("SELECT COUNT(1) FROM product WHERE productName LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    return $count;
}

function getProductInfoSearch($conn, $search, $offset) { //gets the product info from the database
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

function submitReview($conn, $userId, $cakeId, $name, $rating, $description) { //submits a review to the database
    $sql = "INSERT INTO reviews (usersId, cakeId, reviewName, reviewRating, reviewDescription) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../reviewitem.php?id={$cakeId}&error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "iisss", $userId, $cakeId, $name, $rating, $description);
        mysqli_stmt_execute($stmt);
        header("location: ../reviewitem.php?id={$cakeId}&success=reviewadded");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getReviewsByCakeId($conn, $cakeId) { //gets the reviews from the database
    $sql = "SELECT * FROM reviews WHERE cakeId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $cakeId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $reviews = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        return $reviews;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getAverageRatingByCakeId($conn, $cakeId) { //gets the average rating from the database
    $sql = "SELECT AVG(reviewRating) AS avg_rating FROM reviews WHERE cakeId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $cakeId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $avgRating = $row['avg_rating'];
        return $avgRating;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getUserNameFromId ($conn, $userId){ //gets the username from the database
    $sql = "SELECT usersUid FROM users WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $result = $row['usersUid'];
        return $result;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function checkInputLength($input, $min, $max) { //checks the length of the input
    $inputLength = strlen($input);
    if ($inputLength < $min || $inputLength > $max) {
        return false;
    } else {
        return true;
    }
}
?>