<?php

// Database Connection

$host="localhost";
$uname="root";
$pass="root";
$database = "cvdopenmrs";	

$connection=mysql_connect($host,$uname,$pass); 
//or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or die("Database could not be selected");	
$result=mysql_select_db($database)
or die("database cannot be selected <br>");
// Fetch Record from Database

$output			= "";
$table 			= "cvd_basetable"; // Enter Your Table Name
$sql 			= mysql_query("select * from $table limit 10");
$columns_total 	= mysql_num_fields($sql);

// Get The Field Name
for ($i = 0; $i < $columns_total; $i++) {
	$heading[$i]=mysql_field_name($sql, $i);
}
$return_arr=array();
while ($row = mysql_fetch_array($sql, MYSQL_ASSOC)) {
    for($i = 0; $i < $columns_total; $i++) {
     $row_array[$heading[$i]] = $row[$heading[$i]];
     //$row_array['cname'] = $row['cname'];
   }
    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
exit;
	
?>
