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
        $patient_fname = $_POST['patient_fname'];
        $patient_lname = $_POST['patient_lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $is_head_of_hh = $_POST['is_head_of_hh'];
        $hh_id = $_POST['hh_id'];
	$hdc = $_POST['hdc'];
	$rdc = $_POST['rdc'];
	$interview_status = $_POST['interview_status'];
	$patient_ID = $_POST['patient_ID'];
	
       
        WebLog::getInstance()->logInfo("POST parameters extracted");
        echo "Received params  ". $patient_fname . " " . $patient_lname . ".<br />";
               
        
        //database commands here
            //enters if connection to Db is achieved
       // $query = "INSERT INTO testDb ('EVENT_DESC') VALUES '"
       //     .mysql_escape_string($item) ."'";
      
        $query = "INSERT INTO patient (user,date,time,patient_fname, patient_lname, age, gender, is_head_of_hh, hh_id, hdc, rdc, interview_status, patient_ID) VALUES "."('".mysql_escape_string($user)."','".mysql_escape_string($date)."','".mysql_escape_string($time)."','".mysql_escape_string($patient_fname)."','".mysql_escape_string($patient_lname)."','".mysql_escape_string($age)."','".mysql_escape_string($gender)."','".mysql_escape_string($is_head_of_hh)."','".mysql_escape_string($hh_id)."','".mysql_escape_string($hdc)."','".mysql_escape_string($rdc)."','".mysql_escape_string($interview_status)."','".mysql_escape_string($patient_ID)."')";
 
        WebLog::getInstance()->logInfo("query is ".$query);
        
       if(! (mysql_query($query,  GetDatabaseConnection() ) ) )
       {
           echo "Error in insertion of db";
           WebLog::getInstance()->logInfo("Error in DB insertion");
       }
       else
	{
	echo "insertion successful";

      $statsquery = 'INSERT INTO uploadstats (uid,Date,Time,RecordType) VALUES("'.$_POST['tablet_id'].'",curdate(),curtime(),"patient")';
      
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
