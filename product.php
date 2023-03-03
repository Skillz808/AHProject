<title>Baking Bad | Product</title>

<?php
    include_once 'header.php';
?>

<?php
    if (isset($_SESSION["useruid"])){
        echo "<h1>Welcome " . $_SESSION["useruid"] . "</h1>";
    }
?>


<?php
    include_once 'footer.php';
?>