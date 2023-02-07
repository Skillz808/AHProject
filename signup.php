<title>Baking Bad | Signup</title>

<?php
    include_once 'header.php';
?>

<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post"><br>
        <label for="username">Username:</label>
        <input type="text" name="uid" placeholder="Enter Username..."><br>
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Enter Email..."><br>
        <label for="password">Password:</label>
        <input type="password" name="pwd" placeholder="Enter Password..."><br>
        <label for="passwordRepeat">Repeat Password:</label>
        <input type="password" name="pwdrepeat" placeholder="Repeat Password..."><br><br>
        <button type="submit" name="submit" id="submit">Sign Up</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "invaliduid"){
            echo "<p>This username is invalid.</p>";
        }
        else if($_GET["error"] == "invalidemail"){
            echo "<p>This email is invalid.</p>";
        }
        else if($_GET["error"] == "pwddonotmatch"){
            echo "<p>Passwords do not match.</p>";
        }
        else if($_GET["error"] == "stmtfailed"){
            echo "<p>Something went wrong, this is my fault.</p>";
        }
        else if($_GET["error"] == "uidtaken"){
            echo "<p>This username or email has already been registered.</p>";
        }
        else if($_GET["error"] == "none"){
            echo "<p>You have signed up successfully!</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>