<?php
/*********************************************************************
    config.php    
**********************************************************************/

#Disable direct access.
if(!strcasecmp(basename($_SERVER['SCRIPT_NAME']),basename(__FILE__)) || !defined('ROOT_PATH')) die('Access is denied.');

#Default admin email. Used only on db connection issues and related alerts.
define('ADMIN_EMAIL','');

#Mysql Login info    George@123
define('DBTYPE','mysql');
define('DBHOST','localhost'); 
define('DBNAME','openmrs');
define('DBUSER','root');
define('DBPASS','George@123'); 
 
#pagenation default
define('PAGE_LIMIT',100);
	
#Number of dates to display in chart
define('DAYS_LIMIT',15);
	
#Session related    
define('SessionTimeout', 1800);

?>
