<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
    echo "<title>Baking Bad | Product {$_GET['id']}</title>";
?>

<?php
$productInfo = getProductInfo($conn, $_GET['id']);
//return to index if no product is found with current id.
if (empty($productInfo['name'])) {
    header("Location: index.php");
    exit();
}


$image = "{$_GET['id']}.png";
//set image to default if no image is found
echo "<img src='./Images/ProductImages/$image' onerror=\"this.onerror=null;this.src='./Images/ProductImages/default.jpg';\" style='width:30%'>";

echo "<h1 class='productName'>" . $productInfo['name'] . "</h1>";
echo "<p class='productDescription'>" . $productInfo['description'] . "</p>";
echo "<p class='productPrice'>Price: £" . $productInfo['price'] . "</p>";

//Get average rating if there are no reviews, display "No reviews yet..."
$avgRating = getAverageRatingByCakeId($conn, $_GET['id']);
if (empty($avgRating)) {
    echo "No reviews yet..." . "<br><br>";
}
else{
    echo "Average Rating: " . $avgRating . "/5<br><br>";
    echo"<a href='./itemreviews.php?id={$_GET['id']}'><button>Go to item reviews</button></a><br>";
}

//Only show review button if user is logged in
if (!empty($_SESSION["useruid"])) {
    echo"<br><a href='./reviewitem.php?id={$_GET['id']}'><button>Review this item</button></a><br>";
}

echo "<br><p class='phonenumber'>If you are interested in purchasing this cake, Better Call (505) 503-4455! </p>";

?>

<?php
    include_once 'footer.php';
?>
