<?php
require_once('main.inc.php');
  $query = "call copyPatientVisitsTocvd_basetable();";
     //connect to database
  $connection = mysqli_connect(DBHOST,DBUSER, DBPASS, DBNAME, "3306");
  $result = mysqli_query($connection,$query) or die("Query fail: " . mysqli_error());
  echo "success";
  

?>
