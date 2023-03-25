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
        <input type="textarea" name="query" placeholder="Enter Query..."><br>
        <button type="submit" name="submit" id="submit">Submit Query</button>
    </form>
    <br><h3>Example Queries</h3><br>
    <p>INSERT INTO `table` (`column1`, `column2`, `column3`) VALUES ('input1', 'input2', 'input3');</p><br>
    <p>SELECT * FROM `table` WHERE `column1` = input1 </p><br>
    <p>DELETE FROM `table` WHERE `table`.`column1` = input1;</p><br>
    <p>UPDATE `table` SET `column1` = 'input1' WHERE `table`.`column1` = input2; </p>
</section>



<?php
    include_once 'footer.php';
?>