<?php
require_once('main.inc.php');

$result = db_query('Select u.user_id,u.username,pn.given_name,encounter_datetime,
					TIMESTAMPDIFF(DAY,ifnull(encounter_datetime,now()),now()) days,
					TIMESTAMPDIFF(HOUR,ifnull(encounter_datetime,now()),now()) mod 24 hours,
					TIMESTAMPDIFF(MINUTE,ifnull(encounter_datetime,now()),now()) mod 60 minutes
					from users u
					join person_name pn on u.person_id = pn.person_id
					left join (Select max(encounter_datetime) encounter_datetime,creator from encounter
					group by creator order by creator) a on u.user_id = a.creator order by encounter_datetime desc');

$table = '<table border="0" cellspacing=0 cellpadding=0 class="tgrid" align="center" style="border:0px solid #000">
			<tr>
				<th style="text-align:left;">
					ASHA Name</th>
				<th style="text-align:center;">
					Last Encounter Date</th>
				<th style="text-align:center;">
					Time Since Last Encounter</th>
			</tr>';					
									
if($result && ($num=db_num_rows($result))): 
	$count=0;
	while ($row = db_fetch_array($result)) {
		$cssclass = ($count%2==0)?'tr_class_0':'tr_class_1';					
	
		$time_since = "";
		if($row['days'] > 0)
		{
			if($row['days'] == 1)
				$time_since.=$row['days'].' day ';
			else	
				$time_since.=$row['days'].' days ';
		}

		if($row['hours'] > 0)
		{
			if($row['hours'] == 1)
				$time_since.=$row['hours'].' hour ';
			else	
				$time_since.=$row['hours'].' hours ';
		}

		if($row['minutes'] > 0)
		{
			if($row['minutes'] == 1)
				$time_since.=$row['minutes'].' minute';
			else	
				$time_since.=$row['minutes'].' minutes';
		}
		
		if($time_since=="")
			$time_since = "-";
		
		$table.='<tr class="'.$cssclass.'">                
					<td align="left" style="border-left:1px solid #DEDEDE;">&nbsp;'.$row['given_name'].'</td>
					<td align="center">&nbsp;'.$row['encounter_datetime'].'</td>		
					<td align="center" style="border-right:1px solid #DEDEDE;">&nbsp;'.$time_since.'</td>
				</tr>';
		$count++;
	} //end of while.
else: //no records found!! 
	$table.='<tr class=""><td colspan=3 style="padding-left:8px;"><b>No records found.</b></td></tr>';					
endif; 
	
$table.='</table>';

echo $table;

?>