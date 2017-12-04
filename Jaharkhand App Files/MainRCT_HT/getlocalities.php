<?php
require_once('main.inc.php');

function getLocalitiesByVid($vill_name)
{       alert($vill_name);
	$result = db_query("Select distinct(locality) from cvd_basetable where locality is not null and vill_name ='".$vill_name."' order by locality asc;");
        echo $result;
	if($result && db_num_rows($result)){
		$data='';
		while (list($id,$locality) = db_fetch_row($result)) 
		{	
			$data.="<option>".$locality."</option>";
		}	
		return rtrim($data);
	}	
}
 alert("test");
if (isset($_GET['villname'])) {
    alert($_GET['villname']);
    echo getLocalitiesByVid($_GET['villname']);
    
}
