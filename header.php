<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="icon" type="image/x-icon" href="./images/favicon.png">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
    <script type="text/javascript" src="./header.js"></script>
</head>
<body>
<section id="header">
        <div class="header container">
            <div class="nav-bar">
                <div class="brand">
                <div class="logo_container">
                    <a href="./index.php"><img src="./images/logo.png" alt="" class="logoIMG"></a>
                </div>
                </div>
                <div class="nav-list">
                    <div class="hamburger">
                        <div class="bar"></div>
                    </div>
                    <ul>
                    <li><a href ="index.php" data-after="Home">Home</a></li>
                <?php
                    if (isset($_SESSION["useruid"])){
                        if ($_SESSION["admin"] == true){
                            echo "<li><a href='adminpanel.php' data-after='Admin'>Admin</a></li>";
                        }
                        echo "<li><a href='profile.php' data-after='Profile'>Profile</a></li>";
                        echo "<li><a href='./includes/logout.inc.php' data-after='Logout'>Logout</a></li>";
                    }
                    else{
                        echo "<li><a href ='signup.php' data-after='Signup'>Signup</a></li>";
                        echo "<li><a href ='login.php' data-after='Login'>Login</a></li>";
                    }
                ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<div class="wrapper">