<?php

if (isset($_POST["submit"])){
    session_start();

    $userId = $_SESSION["userid"];
    $cakeId = $_POST["cakeID"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $rating  = $_POST["rating"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputReview($name, $description, $rating) !== false) {
        header("location: ../reviewitem.php?id={$cakeId}&error=emptyinput");
        exit();
    }    

    submitReview($conn, $userId, $cakeId, $name, $rating, $description);
}
else {
    header("location: ../login.php");
    exit();
}
?>