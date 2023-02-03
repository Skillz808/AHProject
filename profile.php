<?php
    include_once 'header.php';
?>



<section class="signup-form">
<?php
    if (isset($_SESSION["useruid"])){
        echo "<h2>" . $_SESSION["useruid"] . "'s Profile Page</h2>";
    }
?>
    <form action="includes/profile.inc.php" method="post"><br>
        <label for="email">Current Email:</label>
        <input type="text" name="email" placeholder="Enter Current Email..."><br>
        <label for="currentpassword">Current Password:</label>
        <input type="password" name="currentpwd" placeholder="Enter Current Password..."><br>
        <label for="newemail">New Email:</label>
        <input type="text" name="newemail" placeholder="Enter New Email..."><br>
        <label for="newpassword">New Password:</label>
        <input type="password" name="newpwd" placeholder="Enter New Password..."><br><br>
        <button type="submit" name="submit" id="submit">Submit</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "incorrectpwd"){
            echo "<p>This password is incorrect.</p>";
        }
        else if($_GET["error"] == "invalidemail"){
            echo "<p>This email is invalid.</p>";
        }
        }
?>

<?php
    include_once 'footer.php';
?>
