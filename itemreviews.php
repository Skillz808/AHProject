<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
    echo "<title>Baking Bad | Reviews Of Product {$_GET['id']}</title>";
?>

<?php
$result = getReviewsByCakeId($conn, $_GET['id']);
$productInfo = getProductInfo($conn, $_GET['id']);
if (empty($productInfo['name']) || empty($result)) { //redirect to index if no product found with current id
    header("Location: index.php");
    exit();
}

echo "<section class='generic-form'>";
echo "<h2>Reviews for: {$productInfo['name']}</h2>";
echo "</section>";

foreach ($result as $review) {
    $username = getUserNameFromId($conn, $review['usersId']);
    echo "User Name: " . $username . "<br>";
    echo "Product Name: " . $productInfo['name'] . "<br>";
    echo "Review Name: " . $review['reviewName'] . "<br>";
    echo "Review Description: " . $review['reviewDescription'] . "<br>";
    echo "Review Rating: " . $review['reviewRating'] . "/5 <br><br>";
}

?>