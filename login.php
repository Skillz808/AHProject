<title>Baking Bad | Login</title>

<?php
    include_once 'header.php';
?>

<section class="generic-form">
    <h2>Log In</h2>
    <form action="includes/login.inc.php" method="post"><br>
        <label for="username">Username / Email:</label>
        <input type="text" name="uid" placeholder="Enter Username or Email..." minlength="4" maxlength="255"><br>
        <label for="username">Password:</label>
        <input type="password" name="pwd" placeholder="Enter Password..." minlength="8" maxlength="64"><br><br>
        <button type="submit" name="submit" id="submit">Log In</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){ //display an error message if there is an empty field in the user input
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "incorrectlogin"){ //display an error message if an account with this username/email does not exist
            echo "<p>There is no account registered with this username/email.</p>";
        }
        else if($_GET["error"] == "incorrectpwd"){ //display an error message if the password does not match the account the user is attempting to log in to
            echo "<p>This password is incorrect.</p>";
        }
        }
?>

<?php
    include_once 'footer.php';
?>