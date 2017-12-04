<?php

if($_POST && (!empty($_POST['parse']))){
	require_once('main.inc.php');
	include_once(INCLUDE_DIR.'class.csvparser.php');

	$csv_files = array(
					'phc' => ROOT_DIR.'import/phc.csv',
					'village' => ROOT_DIR.'import/village.csv',				
	);

	$parser = new CsvParser();
	
	$parser->phc_Parser($csv_files['phc']);
	$parser->village_Parser($csv_files['village']);
	$parser->household_parser();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>CSV Parser</title>
	<link rel="stylesheet" href="styles/style.css" type="text/css" />
</head>
<body>
	<div style="width:80%;margin:auto;height:100px;">
	</div>
	<div style="width:80%;margin:auto;">		
	</div>
</body>
</html>


<?php	
}
else{	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>CSV Parser</title>
	<link rel="stylesheet" href="styles/style.css" type="text/css" />
</head>
<body>
	<form action="csvparser.php" method="post">
		<div style="width:80%;margin:auto;height:100px;">
		</div>
		<div style="width:80%;margin:auto;">
			<input type="submit" name="parse" value="Parse" onclick="" />
		</div>
	</form>
</body>
</html>
<?php
}
?>