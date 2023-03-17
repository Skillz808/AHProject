<?php

if (isset($_POST["submit"])){

    $name = $_POST["name"];
    $description = $_POST["description"];
    $rating  = $_POST["rating"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputReview($name, $description, $rating) !== false) {
        header("location: ../reviewitem.php?id={$_GET['id']}&error=emptyinput");
        exit();
    }    
}
else {
    header("location: ../login.php");
    exit();
}
?>