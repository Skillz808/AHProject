<?php
    include_once 'header.php';
?>

<?php
    if ($_SESSION["admin"] == true){
    }
    else{
        header("location:index.php");
    }
?>

<section class="admin-form">
    <h2>Administrator Panel</h2>
    <form action="includes/adminpanel.inc.php" method="post"><br>
        <label for="query">SQL Query:</label>
        <input type="text" name="query" placeholder="Enter Query..."><br>
        <button type="submit" name="submit" id="submit">Submit Query</button>
    </form>
</section>

<?php
    include_once 'footer.php';
?>