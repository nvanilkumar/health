<?php

require_once('main.inc.php');

$html = 'Choose Tablet:
		<select id="tablet" onchange="changeTablet();">
			<option value="" selected>Select Tablet</option>';
			
			$result = db_query('SELECT uid,Name FROM '.TABLETS_TABLE);
			if($result && db_num_rows($result))	{
				while (list($id,$tab) = db_fetch_row($result)) {	
					$html.='<option value="'.$id.'">'.$tab.'</option>';							
				}
			}
							
	$html.='</select>					
	<div id="chartdiv" style="height:300px;width:550px;text-align:center;"></div>';	
	
echo $html;	
?>