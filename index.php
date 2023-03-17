<title>Baking Bad | Home</title>

<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
?>

<section class="search-form">
<form action="./index.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><img class="searchButton" src="./Images/SearchButton.png"></button>
</form>
</section>
    
<div class="grid-container">
<?php
if(empty($_GET['search'])){
  for ($x = 1; $x <= countItems($conn, "product"); $x++) {
    $productInfo = getProductInfo($conn, $x);
    $image = "$x.png";
    echo " <div class='card'>
    <img src='./Images/ProductImages/$image' onerror=\"this.onerror=null;this.src='./Images/ProductImages/default.jpg';\" style='width:100%'>
    <h1 class='nowrap'>{$productInfo['name']}</h1>
    <p class='price'>£" . $productInfo['price'] . "</p>
    <p class='nowrap'>{$productInfo['description']}</p>
    <p><button class='card-button' onclick='redirectToProductPage(\"$x\")'>Go to Product Page</button></p>
  </div> ";
  }
}
else{
  $count = countItemsSearch($conn, $_GET['search']);
  for ($x = 0; $x < $count; $x++) {
      $productInfo = getProductInfoSearch($conn, $_GET['search'], $x);
      $image = "{$productInfo['id']}.png";
      echo " <div class='card'>
      <img src='./Images/ProductImages/$image' onerror=\"this.onerror=null;this.src='./Images/ProductImages/default.jpg';\" style='width:100%'>
      <h1 class='nowrap'>{$productInfo['name']}</h1>
      <p class='price'>£" . $productInfo['price'] . "</p>
      <p class='nowrap'>{$productInfo['description']}</p>
      <p><button class='card-button' onclick='redirectToProductPage(\"{$productInfo['id']}\")'>Go to Product Page</button></p>
      </div> ";
  }
}
?>
</div>

<?php
    include_once 'footer.php';
?>

