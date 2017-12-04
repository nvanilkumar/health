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
	 $tab_id = $_POST['tablet_id'];
        if (!isset($_POST["tablet_id"]))
        {
         exit();
         WebLog::getInstance()->logInfo("Did not retrieve value for your device");
        }
	WebLog::getInstance()->logInfo("Now retrieving parameters");
        //extract parameters
        $phc_code = $_POST['phc_code'];
        $phc_name = $_POST['phc_name'];
       
        WebLog::getInstance()->logInfo("POST parameters extracted");
        echo "Received params  ". $phc_code . " " . $phc_name . ".<br />";
               
        
        //database commands here
            //enters if connection to Db is achieved
       // $query = "INSERT INTO testDb ('EVENT_DESC') VALUES '"
       //     .mysql_escape_string($item) ."'";
      
        $query = "INSERT INTO phc (phc_code, phc_name) VALUES "."('".mysql_escape_string($phc_code)."','".mysql_escape_string($phc_code)."')";
 
        WebLog::getInstance()->logInfo("query is ".$query);
        
       if(! (mysql_query($query,  GetDatabaseConnection() ) ) )
       {
           echo "Error in insertion of db";
           WebLog::getInstance()->logInfo("Error in DB insertion");
       }
       else
	{
	echo "insertion successful";
	}
        WebLog::getInstance()->logInfo("End of procedure");
        ?>
    </body>
</html>
