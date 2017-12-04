<?php
require_once 'BaseLineConfig.php';
// Set up log file
require_once 'KLogger.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
//        $username="your_username";
//        $password="your_password";
//        $database="your_database";
         echo "testing...";
         WebLog::getInstance()->logInfo("Got into the PHP code");
	 $tab_id = $_POST['tablet_id']; //don't forget to include the tablet ID !
	 $user = $_POST['user_id'];
	$date = $_POST['date'];
	$time = $_POST['time'];
        if (!isset($_POST["tablet_id"]))
        {
         exit();
         WebLog::getInstance()->logInfo("Did not retrieve value for your device");
        }
	WebLog::getInstance()->logInfo("Now retrieving parameters");
        //extract parameters
        $hh_UUID = $_POST['hh_UUID'];
        $door_no = $_POST['door_no'];
        $locality_id = $_POST['locality_id'];
        $village_id = $_POST['village_id'];
        $total_hh_size = $_POST['total_hh_size'];
        $total_hh_eligible = $_POST['total_hh_eligible'];
	$hh_head_fname = $_POST['hh_head_fname'];
	$hh_head_lname = $_POST['hh_head_lname'];
	$patient_id_counter = $_POST['patient_id_counter'];       


        WebLog::getInstance()->logInfo("POST parameters extracted");
        echo "Received params  ". $hh_UUID . ".<br />";
               
        
        //database commands here
            //enters if connection to Db is achieved
       // $query = "INSERT INTO testDb ('EVENT_DESC') VALUES '"
        //     .mysql_escape_string($item) ."'";
      
        $query_check_hh_UUID = "Select id from household where hh_UUID='".$hh_UUID."'";
        
        $result =mysql_query($query_check_hh_UUID,  GetDatabaseConnection());

       if($result && db_num_rows($result)){
      
       while ($row = db_fetch_row($result)) { 

             $query = "Update household SET  total_hh_size=".intval($total_hh_size).",total_hh_eligible=".intval($total_hh_eligible).",user='".$user."',date='".$date."',time='".$time."',hh_head_fname='".$hh_head_fname."', hh_head_lname='".$hh_head_lname."', patient_id_counter='".$patient_id_counter."', timestamp=now() where id=".intval($row);
          }
       }else{
             $query = "INSERT INTO household (hh_UUID, door_no, locality_id, village_id, total_hh_size, total_hh_eligible, hh_head_fname, hh_head_lname,patient_id_counter,user,date,time) VALUES "."('".mysql_escape_string($hh_UUID)."','".mysql_escape_string($door_no)."','".mysql_escape_string($locality_id)."','".mysql_escape_string($village_id)."','".mysql_escape_string($total_hh_size)."','".mysql_escape_string($total_hh_eligible)."','".mysql_escape_string($hh_head_fname)."','".mysql_escape_string($hh_head_lname)."','".mysql_escape_string($patient_id_counter)."','".mysql_escape_string($user)."','".mysql_escape_string($date)."','".mysql_escape_string($time)."')";
       }
            
        WebLog::getInstance()->logInfo("query is ".$query);
        
       if(! (mysql_query($query,  GetDatabaseConnection() ) ) )
       {
           echo "Error in insertion of db";
           WebLog::getInstance()->logInfo("Error in DB insertion");
       }
       else
	    {
			echo "insertion successful";
			
			$selectpatientids_query = 'select id from patient where hh_id="'.$hh_UUID.'"';
			WebLog::getInstance()->logInfo("select patient ids query is ".$selectpatientids_query);
			
			$result = mysql_query($selectpatientids_query, GetDatabaseConnection());
			if($result && db_num_rows($result)){
				while (list($id) = db_fetch_row($result)) {	
					$deletePatient = "delete from patient where id=".intval($id);
					WebLog::getInstance()->logInfo("Delete patients query is ".$deletePatient);
					$delresult = mysql_query($deletePatient, GetDatabaseConnection());
					if($delresult)
					{
						WebLog::getInstance()->logInfo("Patient deleted");
					}
					else
					{
						WebLog::getInstance()->logInfo("Patient deletion failed");
					}
					
				}
			}
			else
			{
				WebLog::getInstance()->logInfo("Patient records not found for household ".$hh_UUID);
			}	   		

			$statsquery = 'INSERT INTO uploadstats (uid,Date,Time,RecordType) VALUES("'.$_POST['tablet_id'].'",curdate(),curtime(),"household")';
      
                  WebLog::getInstance()->logInfo("query is ".$statsquery);
                       
                  if(! (mysql_query($statsquery,  GetDatabaseConnection() ) ) )
                  {
                          echo "Error in insertion of db";
                          WebLog::getInstance()->logInfo("Error in DB insertion");
                  }
                  else
                  {
                               echo "insertion successful";
                  }

	    }
        WebLog::getInstance()->logInfo("End of procedure");
        ?>
    </body>
</html>
