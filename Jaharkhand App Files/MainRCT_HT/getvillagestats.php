<?php
require_once('main.inc.php');

function getVillageStats($village)
{			
	$result = db_query('Select count(*),Date(sub.Encounter_Date) 
	from (Select E.encounter_id,person_attr.Village,person_attr.Locality,PID.identifier,
	concat(ifnull(PN.given_name,\'\'),\' \',ifnull(PN.family_name,\'\')) Full_Name,
	PE.Gender,
	(year(now())-year(PE.birthdate)) Age,
	ET.name Encounter_Name,
	E.encounter_datetime Encounter_Date,
	person_attr.ASHA_assigned
	from encounter E 
	JOIN patient P on E.patient_id = P.patient_id
	JOIN encounter_type ET on E.encounter_type = ET.encounter_type_id
	JOIN patient_identifier PID ON P.patient_id = PID.patient_id and PID.identifier_type = 2
	JOIN person PE ON P.patient_id = PE.person_id
	JOIN person_name PN ON PE.person_id = PN.person_id
	JOIN (select aaa.Person_ID,  
		max(if(aaa.Attribute_Name = \'Village\',aaa.Value,NULL)) as \'Village\',     
		max(if(aaa.Attribute_Name =  \'ASHA_assigned\',aaa.Value,NULL)) as  \'ASHA_assigned\',
		max(if(aaa.Attribute_Name = \'PHC\',aaa.Value,NULL)) as \'PHC\',
		max(if(aaa.Attribute_Name = \'Locality\',aaa.Value,NULL)) as \'Locality\'
		from (Select 
				a.person_id as Person_ID,
				PAT.name Attribute_Name,
				a.Value as Value
				from (Select * from person_attribute order by date_created desc) a
		JOIN person_attribute_type PAT ON a.person_attribute_type_id = PAT.person_attribute_type_id
		group by a.person_attribute_type_id , person_id
		order by a.person_id asc, a.person_attribute_type_id ) aaa 
	group by aaa.Person_ID order by aaa.Person_ID) person_attr on PE.person_id = person_attr.Person_ID 
	order by person_attr.Village) sub
	where sub.Village = \''.$village.'\'
	group by Date(sub.Encounter_Date) order by sub.Encounter_Date asc');
	
	if($result && db_num_rows($result))	{
		$data='';
		while (list($count,$date) = db_fetch_row($result)) 
		{	
			$data.=$date.','.$count.'#';		
		}	
		return rtrim($data,'#');
	}
	else
	{
		return 'false';
	}
}
if(isset($_GET['village']))
	echo getVillageStats($_GET['village']);
?>