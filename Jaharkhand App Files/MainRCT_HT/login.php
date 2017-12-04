<?php
/*********************************************************************
    login.php    
**********************************************************************/
require_once('main.inc.php');
if(!defined('INCLUDE_DIR')) die('Fatal Error.');

$msg=$_SESSION['_staff']['auth']['msg'];

if($_POST && (!empty($_POST['username']) && !empty($_POST['passwd']))){    

    if(($user=new StaffSession($_POST['username'])) && $user->getId() && $user->check_passwd($_POST['passwd']))
	{                       
        $_SESSION['_staff']=array(); //clear.
        $_SESSION['_staff']['userID']=$_POST['username'];
		$_SESSION['_staff']['FName']=$user->firstname;
        $user->refreshSession();        
        session_write_close();
        session_regenerate_id();
		@header("Location: index.php");
        require_once('index.php');
        exit;
    }
	else 
	{
		$msg='Invalid username and password';
	}
}
define("HTINC",TRUE); //Make includes happy!

include_once('login.tpl.php');
?>
