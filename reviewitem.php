<?php
    include_once 'header.php';
    require_once './includes/dbh.inc.php';
    require_once './includes/functions.inc.php';
    $productInfo = getProductInfo($conn, $_GET['id']);
    if (empty($productInfo['name']) || empty($_SESSION["useruid"])) { //redirect to index if no product found with current id or if user is not logged in
        header("Location: index.php");
        exit();
    }
    echo "<title>Baking Bad | Reviewing Product: {$productInfo['name']}</title>";
?>

<section class="generic-form">
    <?php
    echo"<h2>Reviewing: {$productInfo['name']}</h2>"
    ?>
    <form action="includes/reviewitem.inc.php" method="post"><br>
        <label for="reviewName">Review Name:</label>
        <input type="text" name="name" placeholder="Enter Review Name..."minlength="4" maxlength="30"><br>
        <label for="reviewDescription">Review Description:</label>
        <input type="text" name="description" placeholder="Enter Review Description..."minlength="20" maxlength="255"><br>
        <label for="reviewRating">Review Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" placeholder="Enter a value between 1 and 5"><br><br>
        <input type="hidden" name="cakeID" value="<?= $_GET['id']?>">
        <button type="submit" name="submit" id="submit">Submit</button>
    </form>
</section>

<?php
    if (isset($_GET["error"])){ //display an error message if there is an empty field in the user input
        if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields</p>";
        }
    }
    if (isset($_GET["success"])){ //display a success message if the review was added successfully
         if($_GET["success"] == "reviewadded"){
        echo "<p>Review submitted successfully.</p>";
    }
}
    
    
?>

<?php
    include_once 'footer.php';
?>