<?php
require_once('main.inc.php');
include_once(INCLUDE_DIR.'class.user.php');

if(isset($_GET['pwd'])) {
	$user = new User($_SESSION['_staff']['userID']);
	
	if($user->check_passwd($_GET['pwd'])) {
		echo "true";
	}
	else {
		echo "false";
	}
}

?>