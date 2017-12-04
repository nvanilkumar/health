<?php 
if(basename($_SERVER['SCRIPT_NAME'])==basename(__FILE__)) die('Access Denied.');
if(!file_exists('main.inc.php')) die('Fatal error..');

define('ROOT_PATH','../'); //Path to the root dir.
require_once('main.inc.php');

if(!defined('INCLUDE_DIR')) die('Fatal error');

/* Define tag that included files can check */
define('HTTAG',TRUE);

function staffLoginPage($msg) {    
    $_SESSION['_staff']['auth']['msg']=$msg;
    require('login.php');
    exit;
}

$thisuser = ($_SESSION['_staff']['userID']!='') ? new StaffSession($_SESSION['_staff']['userID']) : null;

if(!is_object($thisuser) || !$thisuser->getId() || !$thisuser->isValid()){
    $msg=(!$thisuser || $thisuser->isValid())?'Authentication Required':'Session expired';
    staffLoginPage($msg);
    exit;
}

//Keep the session activity alive
$thisuser->refreshSession();

?>