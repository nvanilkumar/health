<?php
/*********************************************************************
    main.inc.php

    Master include file which must be included at the start of every file.
    The brain of the whole sytem.    
**********************************************************************/
	#Disable direct access.
	
    if(!strcasecmp(basename($_SERVER['SCRIPT_NAME']),basename(__FILE__))) die('Access Denied.');
	
	#Disable Globals if enabled....before loading config info
    if(ini_get('register_globals')) {
       ini_set('register_globals',0);
       foreach($_REQUEST as $key=>$val)
           if(isset($$key))
               unset($$key);
    }
	
	#Disable session ids on url.
    ini_set('session.use_trans_sid', 0);
    #No cache
    ini_set('session.cache_limiter', 'nocache');
	
	ini_set('max_execution_time', 1800);
	
	#Error reporting...Good idea to ENABLE error reporting to a file. i.e display_errors should be set to false
    error_reporting(E_ALL ^ E_NOTICE); //Respect whatever is set in php.ini (sysadmin knows better??)
    #Don't display errors
    ini_set('display_errors',0);
    ini_set('display_startup_errors',0);
	
	//Start the session
    session_start();

    #Set Dir constants
    if(!defined('ROOT_PATH')) define('ROOT_PATH','./'); //root path. Damn directories
    define('ROOT_DIR',str_replace('\\\\', '/', realpath(dirname(__FILE__))).'/'); #Get real path for root dir ---linux and windows
    define('INCLUDE_DIR',ROOT_DIR.'include/'); //Change this if include is moved outside the web path.
	define('DATA_DIR',ROOT_DIR.'data/');
	define('SERVICES_DIR',ROOT_DIR.'services/');
	
	#load config info
    $configfile = '';
    if(file_exists(INCLUDE_DIR.'config.php'))
        $configfile = INCLUDE_DIR.'config.php';
		
	if(!$configfile || !file_exists($configfile)) die('<b>Error loading settings. Contact admin.</b>');
	
	require($configfile);
    define('CONFIG_FILE',$configfile); //used in admin.php to check perm.
	
	//Path separator
    if(!defined('PATH_SEPARATOR')){
        if(strpos($_ENV['OS'],'Win')!==false || !strcasecmp(substr(PHP_OS, 0, 3),'WIN'))
            define('PATH_SEPARATOR', ';' ); //Windows
        else 
            define('PATH_SEPARATOR',':'); //Linux
	}
			
	#include required files
	require(INCLUDE_DIR.'class.usersession.php');
	require(INCLUDE_DIR.'class.pagenate.php'); //Pagenate helper!
    require(INCLUDE_DIR.'class.sys.php');
    require(INCLUDE_DIR.'mysql.php');
	
	#pagenation default
    if(!defined('PAGE_LIMIT'))
  	  	define('PAGE_LIMIT',10);
 
	
	#Number of dates to display in chart
	if(!defined('DAYS_LIMIT'))
		define('DAYS_LIMIT',15);
	
	#Session related    
 	if(!defined('SessionTimeout'))
	    define('SessionTimeout', 1800);
	
	#Tables being used sytem wide
    define('USERS_TABLE','users');
	define('TABLETS_TABLE','tablets');
	define('PHC_TABLE','phc');
	define('PHC_VILLAGE_MAP_TABLE','phc_village_map');
	define('HOUSEHOLD_TABLE','household');
	define('LOCALITY_TABLE','locality');
	define('VILLAGE_TABLE','village');
	define('PATIENT_TABLE','patient');	
	define('UPLOADSTATS_TABLE','uploadstats');
	define('RISKFACTORS_TABLE','risk_factors');
	
	#Connect to the DB && get configuration from database
    $ferror=null;
    if (!db_connect(DBHOST,DBUSER,DBPASS) || !db_select_database(DBNAME)) {
        $ferror='Unable to connect to the database';
    }
		
	#Cleanup magic quotes crap.
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $_POST=Format::strip_slashes($_POST);
        $_GET=Format::strip_slashes($_GET);
        $_REQUEST=Format::strip_slashes($_REQUEST);
    }
?>