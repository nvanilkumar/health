<?php
/*********************************************************************
    class.csvparser.php
**********************************************************************/

class CsvParser{	

	function CsvParser(){	
		
		
	}
	
	function phc_Parser($filename='', $delimiter=',')
	{			
		echo '<br/>';
		echo '---------------------------------- starting phc_Parser ----------------------------------';
		echo '<br/>';
		
		if(!file_exists($filename) || !is_readable($filename))
			echo $filename." doesn't exist.";
		else 
		{			
			$result = db_query('TRUNCATE TABLE '.PHC_TABLE);			
			$header = NULL;
			$data = array();
			if (($handle = fopen($filename, 'r')) !== FALSE)
			{
				while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
				{
					if(!$header){
						$header = array('SNo','phc_code','phc_name');;
					}
					else
					{
						$data[] = array_combine($header, $row);					
					}
				}			
				fclose($handle);
				
				echo '************************************ Insert query of phc ************************************';
				echo '<br/>';
				echo '<br/>';
				
				foreach($data as $row)
				{
					$sql = sprintf('INSERT INTO '.PHC_TABLE.' (phc_code,phc_name,timestamp) values('.intval($row['phc_code']).',"'.$row['phc_name'].'",now())');
					
					echo $sql;
					echo '<br/>';
					$res=db_query($sql);
					if($res)
					{
						echo '<br/>';
						echo 'phc record inserted successfully';
						echo '<br/>';
					}
					else
					{
						echo '<br/>';
						echo 'phc record insertion failed';
						echo '<br/>';
					}
				}									
			}
			echo '---------------------------------- phc_Parser completed ----------------------------------';
			echo '<br/>';			
		}
	}
	
	function village_Parser($filename='', $delimiter=',')
	{
		echo '<br/>';
		echo '---------------------------------- starting village_Parser ----------------------------------';
		echo '<br/>';
		
		if(!file_exists($filename) || !is_readable($filename))
			echo $filename." doesn't exist.";
		else
		{
			$res = db_query('TRUNCATE TABLE '.LOCALITY_TABLE);
			$result = db_query('TRUNCATE TABLE '.VILLAGE_TABLE);
			
			$header = NULL;
			$data = array();
			if (($handle = fopen($filename, 'r')) !== FALSE)
			{
				while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
				{
					if(!$header){
						
						$header = array('SNo', 'village_name', 'phc_code');
					}
					else
					{
						$villagedata = array();
						$localitydata = array();					
						
						for($i=0;$i<count($row);$i++)
						{
							if($i<3)
							{
								array_push($villagedata,$row[$i]);
							}
							else
							{
								array_push($localitydata,$row[$i]);
							}
						}
						$data = null;
						
						$data[] = array_combine($header, $villagedata);
						
						foreach($data as $v)
						{
							echo '************************************ Insert query of Village ************************************';
							echo '<br/>';
							$sql = sprintf('INSERT INTO '.VILLAGE_TABLE.' (phc_code,village_name,timestamp) values('.intval($v['phc_code']).',"'.$v['village_name'].'",now())');
							echo $sql.'<br/>';
							$res=db_query($sql);						
							if($res)
							{
								$villageid = db_insert_id();
								echo '<br/>';
								echo 'village record inserted successfully';
								echo '<br/>';
								echo '<br/>';
								echo '************************************ Insert query of Locality ************************************';
								echo '<br/>';
								foreach($localitydata as $locality)
								{
									if($locality!=''){
										$sql = sprintf('INSERT INTO '.LOCALITY_TABLE.' (village_id,locality_name,timestamp) values('.intval($villageid).',"'.$locality.'",now())');
										echo $sql.'<br/>';
										$result=db_query($sql);
										if($result)
										{
											echo '<br/>';
											echo 'locality record inserted successfully';
											echo '<br/>';
										}
										else
										{
											echo '<br/>';
											echo 'locality record insertion failed';
											echo '<br/>';
										}									
									}
								}
							}
							else
							{
								echo '<br/>';
								echo 'village record insertion failed';
								echo '<br/>';
							}
							echo '<br/>';
							echo '<br/>';
						}										
					}
				}
				
				fclose($handle);									
			}
		}
		echo '<br/>';
		echo '---------------------------------- village_Parser completed ----------------------------------';
	}
	
	function household_parser($delimiter=',')
	{
		echo '<br/>';
		echo '---------------------------------- starting household_parser ----------------------------------';
		echo '<br/>';
		$patienttruncate = db_query('TRUNCATE TABLE '.PATIENT_TABLE);
		$householdtruncate = db_query('TRUNCATE TABLE '.HOUSEHOLD_TABLE);
		$result = db_query('SELECT ID,village_name FROM '.VILLAGE_TABLE);
		
		if($result && db_num_rows($result))	{
			while (list($villageid,$village) = db_fetch_row($result)) {	
				$filename = 'import'.'/patient_'.$village.'.csv';				
				if(!file_exists($filename) || !is_readable($filename)) {
					echo $filename." doesn't exist.";
				}
				else 
				{
					echo '************************************ '.$filename.' ************************************';
					echo '<br/>';
					echo '<br/>';
					echo $filename.' parsing started....';
					echo '<br/>';
					echo '<br/>';							
					
					$localityres = db_query('select ID,locality_name from '.LOCALITY_TABLE.' where village_id='.intval($villageid));
					
					if($localityres && db_num_rows($localityres))	{
						$localities=null;
						while (list($id,$locality) = db_fetch_row($localityres)) 
						{	
							$localities[$locality] = $id;
						}						
					}				
					
					$header = NULL;
					$data = array();
					if (($handle = fopen($filename, 'r')) !== FALSE)
					{
						while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
						{
							if(!$header){							
								$header = array('SNo','DoorNo','Locality','HH_UUID','Hh_head_FN','Hh_head_LN','Hh_size','Hh_Eligible_Member_count');
								echo count($header);
								echo '<br/>';
							}
							else
							{							
								$householddata = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
															
								$data = null;
								
								$data[] = array_combine($header, $householddata);
								
								foreach($data as $v)
								{
									$hh_id = $v['HH_UUID']!=''?$v['HH_UUID']:"-1";
									$hh_size = $v['Hh_size']!=''?intval($v['Hh_size']):-1;
									$hh_eligible = $v['Hh_Eligible_Member_count']!=''?intval($v['Hh_Eligible_Member_count']):0;
									echo '************************************ Insert query of household ************************************';
									echo '<br/>';
									$sql = sprintf('INSERT INTO '.HOUSEHOLD_TABLE.' (hh_UUID,door_no,locality_id,village_id,total_hh_size,total_hh_eligible,hh_head_fname,hh_head_lname,timestamp) 
									values("'.$hh_id.'","'.$v['DoorNo'].'",'.intval($localities[$v['Locality']]).','.intval($villageid).','.$hh_size.','.$hh_eligible.',"'.$v['Hh_head_FN'].'","'.$v['Hh_head_LN'].'",now())');
									echo $sql.'<br/><br/>';
									$res=db_query($sql);						
									if($res)
									{
										echo '<br/>';
										echo 'household record inserted successfully';
										echo '<br/>';
										echo '<br/>';
										$eligiblepatients = $v['Hh_Eligible_Member_count']!=''?intval($v['Hh_Eligible_Member_count']):0;
										echo 'Eligible patients count : '.$eligiblepatients;
										echo '<br/>';
										echo '<br/>';
										$patientindex = count($householddata);
										
										if($eligiblepatients){
											echo '************************************ Insert query of patient ************************************';
											echo '<br/>';
											echo '<br/>';
										}
										for($i=1;$i<=$eligiblepatients;$i++)
										{
											$age = $row[$patientindex+3]!='' ? intval($row[$patientindex+3]) : -1;
											$interview_status = $row[$patientindex+4]!='' ? intval($row[$patientindex+4]) : -1;
											$hdc = $row[$patientindex+5]!='' ? intval($row[$patientindex+5]) : -1;
											$rdc = $row[$patientindex+6]!='' ? intval($row[$patientindex+6]) : -1;										
											
											if(!strcmp(strtoupper(trim($row[$patientindex])),strtoupper(trim($v['Hh_head_FN']))) && !strcmp(strtoupper(trim($row[$patientindex+1])),strtoupper(trim($v['Hh_head_LN']))))
											{
												$is_head_of_hh = 1;
											}
											else
											{
												$is_head_of_hh = 0;
											}
											$patientsql = sprintf('INSERT INTO '.PATIENT_TABLE.' (patient_fname,patient_lname,gender,age,interview_status,hdc,rdc,hh_id,is_head_of_hh,patient_ID)
											values("'.$row[$patientindex].'","'.$row[$patientindex+1].'","'.$row[$patientindex+2].'",'.$age.','.$interview_status.','.$hdc.','.$rdc.',"'.$hh_id.'",'.$is_head_of_hh.',-1)');
											
											echo $patientsql.'<br/>';
											$patientres=db_query($patientsql);
											if($patientres)
											{
												echo '<br/>';
												echo 'patient record inserted successfully';
												echo '<br/>';										
											}
											else
											{
												echo '<br/>';
												echo 'patient record insertion failed';
												echo '<br/>';										
											}
											$patientindex = $patientindex + 7;
										}
									}
									else
									{
										echo '<br/>';
										echo 'household record insertion failed';
										echo '<br/>';
									}
								}
							}
						}					
						fclose($handle);									
					}
				}
			}
		}
		echo '<br/>';
		echo '---------------------------------- household_parser completed ----------------------------------';
	}
}
?>