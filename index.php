<?php
	require 'load/load.php';
	 checkcookie('0', isset($_COOKIE['user']), isset($_COOKIE['pass']), $CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);
	$page = isset($_GET['page']);
	
	if ($page=="login" && isset($_POST['submit']) && antiinjection($_POST['username'])!=="" && antiinjection($_POST['password'])!=="") {
			if($CONFIG['securitycode']=="1") {
				if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
					echo "Incorrect verification code.<br />";
					quickrefresh('index.php');
					exit();
				}
			}
			$conn = connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);
			$postusername = $_POST['username'];
			$postpassword = $_POST['password'];
			$postusername = antiinjection($postusername);
			$postpassword = antiinjection($postpassword);

			$stmt = sqlsrv_query($conn, sprintf(SELECT_USER_PASS,$postusername));
			// Returns a row as an array
			$rows = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
			 
			if($rows > 0){
				extract($rows);

				$password = '0x' . bin2hex($password);

				if(encrypt($postpassword)==$password) {
					setcookie ("user", $account, time()+2592000);
					setcookie ("pass", md5($password), time()+2592000);
					quickrefresh('home.php');
				} else {
					echo '
					<script language="JavaScript">
					alert("Password is incorrect.");
					</script>
					';
				}
			} 
			else {
				echo '
				<script language="JavaScript">
				alert("No such account.");
				console.log("xD'. $rows . '");
				</script>
				';
			}
			quickrefresh('index.php');
			}
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Lineage II Control Panel</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#B2CAFA">
<table width="703" align="center" border="0" cellpadding="0">
	<tr>
		<td height="96">
			<center>
				<img src="images/title.jpg" border="0" alt="" />
			</center>
		</td>
	</tr>
	<tr>
		<td valign="middle" width="703" style="background: url(images/menubar.gif); border:1px solid black;" height="30">
			<div align="left" class="normal" style="margin-left: 10px;margin-right: 10px;">
				<a href="index.php"><img src="images/home.jpg" border="0" alt="" align="middle" /></a>
			</div>
		</td>
	</tr>
<?php
if ($CONFIG['cp']=="1") {
$securitycheck = "1";

	if (!$page) {
		require('pages/login.php');
	}elseif (file_exists("pages/".$page.".php")) { 
		switch($page) { 
		default: require('pages/login.php');
		break; case "register": require('pages/register.php');
		break; case "lostpassword": require('pages/lostpassword.php');
		}
	} else { 
		require('pages/error.php');
	} 
}else{
	echopage('header', 'Login');
	echo $CONFIG['cpreason'];
	echopage('footer', '');
}

echoindex('space');
echoindex('credits');
echoindex('end');
?>
</html>