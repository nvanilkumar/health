<?php
/*********************************************************************
    logout.php
**********************************************************************/
require('staff.inc.php');
$_SESSION['_staff']=array();
unset($_SESSION['_staff']['userID']);
unset($_SESSION['_staff']['FName']);
session_unset();
session_destroy();
@header('Location: login.php');
require('login.php');
?>
