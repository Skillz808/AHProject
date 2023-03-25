<title>Baking Bad | Profile</title>

<?php
    include_once 'header.php';
?>



<section class="generic-form">
<?php
    if (isset($_SESSION["useruid"])){ //display the user's username in the header
        echo "<h2>" . $_SESSION["useruid"] . "'s Profile Page</h2>";
    }
    if (empty($_SESSION["useruid"])){ //redirect the user to the login page if they are not logged in
        header("Location: index.php");
        exit();
    }
?>
    <form action="includes/profile.inc.php" method="post"><br>
        <label for="newemail">New Email:</label>
        <input type="text" name="newemail" placeholder="Enter New Email..."><br>
        <label for="newpassword">New Password:</label>
        <input type="password" name="newpwd" placeholder="Enter New Password..."><br><br>
        <button type="submit" name="submit" id="submit">Submit</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){ //display an error message if there is an empty field in the user input
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
        else if($_GET["error"] == "incorrectpwd"){ //display an error message if the password does not match the account the user is attempting to log in to
            echo "<p>This password is incorrect.</p>";
        }
        else if($_GET["error"] == "invalidemail"){ //display an error message if the email is invalid
            echo "<p>This email is invalid.</p>";
        }
        }
?>

<?php
    include_once 'footer.php';
?>
