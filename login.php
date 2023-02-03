<?php
    include_once 'header.php';
?>

<section class="signup-form">
    <h2>Log In</h2>
    <form action="includes/login.inc.php" method="post"><br>
        <label for="username">Username / Email:</label>
        <input type="text" name="uid" placeholder="Enter Username or Email..."><br>
        <label for="username">Password:</label>
        <input type="password" name="pwd" placeholder="Enter Password..."><br><br>
        <button type="submit" name="submit" id="submit">Log In</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "incorrectlogin"){
            echo "<p>There is no account registered with this username/email.</p>";
        }
        else if($_GET["error"] == "incorrectpwd"){
            echo "<p>This password is incorrect.</p>";
        }
        }
?>

<?php
    include_once 'footer.php';
?>