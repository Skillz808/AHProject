<title>Baking Bad | Home</title>

<?php
    include_once 'header.php';
?>

<?php
    if (isset($_SESSION["useruid"])){
        echo "<h1>Welcome " . $_SESSION["useruid"] . "</h1>";
    }
?>
<div class="grid-container">
<?php
for ($x = 0; $x <= 11; $x++) {
  echo "<a href='product.php?='$x'>Product '$x'<a>";
}
?>
</div>

<?php
    include_once 'footer.php';
?>

