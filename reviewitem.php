<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
    $productInfo = getProductInfo($conn, $_GET['id']);
    if (empty($productInfo['name'])) {
        header("Location: index.php");
        exit();
    }
    echo "<title>Baking Bad | Reviewing Product: {$productInfo['name']}</title>";
?>

<section class="signup-form">
    <?php
    echo"<h2>Reviewing: {$productInfo['name']}</h2>"
    ?>
    <form action="includes/reviewitem.inc.php" method="post"><br>
        <label for="reviewName">Review Name:</label>
        <input type="text" name="name" placeholder="Enter Review Name..."><br>
        <label for="reviewDescription">Review Description:</label>
        <input type="text" name="description" placeholder="Enter Review Description..."><br>
        <label for="reviewRating">Review Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" placeholder="Enter a value between 1 and 5"><br><br>
        <button type="submit" name="submit" id="submit">Submit Review</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
    }
    
?>

<?php
    include_once 'footer.php';
?>