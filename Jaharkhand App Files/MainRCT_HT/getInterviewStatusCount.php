<?php
require_once('main.inc.php');

function getInterviewStatusCount($id)
{
	$result = db_query('select count(*) count from '.PATIENT_TABLE.' p
						join '.HOUSEHOLD_TABLE.' h on p.hh_id = h.hh_UUID
						join '.VILLAGE_TABLE.' v on h.village_id = v.id
						where p.interview_status=1 and v.id='.intval($id));
	
	if($result && db_num_rows($result))	{
		$data='';
		while (list($count) = db_fetch_row($result)) 
		{	
			$data.='Number of interviews done = '.$count;		
		}			
	}

	$result1 = db_query('select count(*) count from '.PATIENT_TABLE.' p
						join '.HOUSEHOLD_TABLE.' h on p.hh_id = h.hh_UUID
						join '.VILLAGE_TABLE.' v on h.village_id = v.id
						where p.interview_status=2 and v.id='.intval($id));
	
	if($result1 && db_num_rows($result1))	{		
		while (list($count) = db_fetch_row($result1)) 
		{	
			$data.='&Number of interviews not done = '.$count;		
		}			
	}
	
	echo $data;
}
if(isset($_GET['id']))
	echo getInterviewStatusCount($_GET['id']);
?>