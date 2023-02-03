<?php
    include_once 'header.php';
?>

<?php
    if (isset($_SESSION["useruid"])){
        echo "<h1>Welcome " . $_SESSION["useruid"] . "</h1>";
    }
?>
<p>This is the index page!!</p>
<p>There is nothing to see here... yet.</p>

<?php
    include_once 'footer.php';
?>

