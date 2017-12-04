<?php
if(!defined('HTINC')) die('Access Denied');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Smart Health - Login</title>
	<link rel="stylesheet" href="styles/style.css" type="text/css" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<meta name="robots" content="noindex" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<script type="text/javascript">
		function validateForm()
		{
			if( document.forms[0]["username"].value == "")
			{
				document.getElementById("errorMessage").innerHTML="Username required";
				return false;
			}
			if( document.forms[0]["passwd"].value == "")
			{
				document.getElementById("errorMessage").innerHTML="Password required";
				return false;
			}
		}
	</script>
</head>
<body>
	<div class="login_bg">
		<div class="login_logo">
			<img src="images/login_logo.png"/>
		</div>
		<div class="clear">
		</div>
		<form action="login.php" method="post">
			<div class="login_box">
				<div style="text-align:center; padding:3px 0 3px 0;">
					<h1>Login</h1>
				</div>
				<div class="label_div">
					Username :
				</div>
				<div class="input_div">
					<input type="text" name="username" id="name" value="" class="textarea"/>
				</div>
				<div class="clear">
				</div>
				<div class="label_div">
					Password :
				</div>
				<div class="input_div">
					<input type="password" name="passwd" id="pass" class="textarea" />
				</div>
				<div class="clear">
				</div>
				<div style="margin-top:10px; padding:0 0 9px 0;">
					<div style="width:auto; float:right; margin-top:10px; margin-right:46px;">
						<input class="submit_button" type="submit" name="submit" value="Go" onclick="return validateForm();" />
					</div>
					<div id="errorMessage" class="forgot_password" style="width:182px; float:right; padding-top:9px; margin-top:5px; color: #EFA71E;">						
						<?if(isset($msg)){ print $msg;}?>
					</div>
					<div class="clear">
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
