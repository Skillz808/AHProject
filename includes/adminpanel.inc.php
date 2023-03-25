<?php

if (isset($_POST["submit"])){

    $query = $_POST["query"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $result = executeQuery($conn, $query);

    if ($result->num_rows > 0) {
      // get column names from result set
      $columns = array_keys($result->fetch_assoc());
  
      // output data of each row
      while($row = $result->fetch_assoc()) {
          // build output string with placeholders
          $output = "";
          foreach($columns as $column) {
              $output .= "$column: {{".$column."}} - ";
          }
          $output = rtrim($output, " - "); // remove trailing dash
  
          // replace placeholders with actual values
          foreach($row as $key => $value) {
              $output = str_replace("{{".$key."}}", $value, $output);
          }
  
          echo $output . "<br>";
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