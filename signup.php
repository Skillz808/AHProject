<title>Baking Bad | Signup</title>

<?php
    include_once 'header.php';
?>

<section class="generic-form">
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post"><br>
        <label for="username">Username:</label>
        <input type="text" name="uid" placeholder="Enter Username..."minlength="4" maxlength="30"><br>
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Enter Email..." minlength="5" maxlength="255"><br>
        <label for="password">Password:</label>
        <input type="password" name="pwd" placeholder="Enter Password..." minlength="8" maxlength="64"><br>
        <label for="passwordRepeat">Repeat Password:</label>
        <input type="password" name="pwdrepeat" placeholder="Repeat Password..." minlength="8" maxlength="64"><br><br>
        <button type="submit" name="submit" id="submit">Sign Up</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){ //display an error message if there is an empty field in the user input
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "invaliduid"){ //display an error message if the username is invalid for example if it contains special characters
            echo "<p>This username is invalid.</p>";
        }
        else if($_GET["error"] == "invalidemail"){ //display an error message if the email is invalid
            echo "<p>This email is invalid.</p>";
        }
        else if($_GET["error"] == "pwddonotmatch"){ //display an error message if the passwords do not match
            echo "<p>Passwords do not match.</p>";
        }
        else if($_GET["error"] == "stmtfailed"){ //display an error message if the SQL statement fails
            echo "<p>Something went wrong, this is my fault.</p>";
        }
        else if($_GET["error"] == "uidtaken"){ //display an error message if the username or email has already been registered
            echo "<p>This username or email has already been registered.</p>";
        }
        else if($_GET["error"] == "none"){ //display a success message if the user has successfully signed up
            echo "<p>You have signed up successfully!</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>