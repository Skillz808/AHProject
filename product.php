<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
    echo "<title>Baking Bad | Product {$_GET['id']}</title>";
?>

<?php
$productInfo = getProductInfo($conn, $_GET['id']);

echo "<img class='productImage' src='./Images/ProductImages/default.jpg' alt='uh oh error!' style='width:30%'>";

echo "<h1 class='productName'>" . $productInfo['name'] . "</h1>";
echo "<p class='productDescription'>" . $productInfo['description'] . "</p>";
echo "<p class='productPrice'>Price: £" . $productInfo['price'] . "</p>";
?>


<?php
    include_once 'footer.php';
?>
