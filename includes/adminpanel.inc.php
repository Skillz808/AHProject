<?php

if (isset($_POST["submit"])){

    $query = $_POST["query"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    //no validation needed maybe probably

    $result = executeQuery($conn, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "id: " . $row["usersId"]. " - Name: " . $row["usersUid"]. " - Email: " . $row["usersEmail"]. " - Password(Hashed): " . $row["usersPwd"]. " - IsAdmin?: " . $row["isAdmin"]. "<br>";
        }
      } else {
        echo "0 results";
      }
}
else {
    header("location: ../adminpanel.php");
    exit();
}
?>