<?php
	require 'load/load.php';
	checkcookie('1', isset($_COOKIE['user']), isset($_COOKIE['pass']), $CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);

	$page = isset($_GET['page']);
	if ($page=="logout") {
		resetcookies();
		quickrefresh('index.php');
	}
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
<?php

echo '<script type="text/javascript" language="JavaScript1.2" src="menu.js"></script>';
nocache();
echo '
	<tr>
		<td valign="middle" width="703" style="background: url(images/menubar.gif); border:1px solid black;" height="30">
			<div align="left" class="normal" style="margin-left: 10px;margin-right: 10px;">
				<script type="text/javascript" language="JavaScript1.2">
					<!--
					stm_bm(["tubtehr",430,"","images/blank.gif",0,"","",0,0,250,0,250,1,0,0,"","",0],this);
					stm_bp("p0",[0,4,0,0,0,0,5,0,100,"",-2,"",-2,90,0,0,"#000000","transparent","",3,0,0,"#ffffff"]);
					stm_ai("p0i0",[2,"","images/home.jpg","images/home.jpg",0,0,0,"home.php","_self","","","","",0,0,0,"","",0,0,0,0,1,"#3399ff",1,"#3399ff",1,"","",3,3,0,0,"#ffffff","#ffffff","#ffffff","#ff0000","bold 8pt Arial","bold 8pt Arial",0,0]);
					stm_aix("p0i1","p0i0",[2,"","images/options.jpg","images/options.jpg",0,0,0,"","_self","","","","",5,1]);
					stm_bpx("p1","p0",[1,4,5,0,3,0,0,0,100,"progid:DXImageTransform.Microsoft.Wipe(GradientSize=1.0,wipeStyle=1,motion=forward,enabled=0,Duration=0.60)",5,"progid:DXImageTransform.Microsoft.Wipe(GradientSize=1.0,wipeStyle=1,motion=reverse,enabled=0,Duration=0.60)",4,50,0,0,"#999999"]);
					stm_aix("p1i0","p0i0",[2,"","images/changepassword.jpg","images/changepassword.jpg",0,0,0,"home.php?page=changepassword","_self","","","","",0,0,0,"","",0,0,0,0,0]);
					stm_ep();
					stm_aix("p0i2","p0i1",[2,"","images/logout.jpg","images/logout.jpg",0,0,0,"home.php?page=logout"]);
					stm_ep();
					stm_em();
					//-->
				</script>
			</div>
		</td>
	</tr>
';

if ($CONFIG['cp']=="1") {
$securitycheck = "1";

$page = isset($_GET['page']);

	if (!$page) {
		require('pages/announcement.php');
	}else{
		switch($page) { 
		default: require('pages/announcement.php');
		break; case "changepassword": require('pages/changepassword.php');
		break; case "castlesieges": require('pages/castlesieges.php');
		}
	}
}else{
	echopage('header', 'Announcements');
	echo $CONFIG['cpreason'];
	echopage('footer', '');
}

echoindex('space');
echoindex('credits');
echoindex('end');
?>