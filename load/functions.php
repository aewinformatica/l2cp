<?php
function antiinjection($str) {
	$str = preg_replace("[^A-Za-z0-9]", "", $str);
	return $str;
}

function isEmailAddress($strEmail) {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
        if(strstr($strEmail, '@') && strstr($strEmail, '.')) {
                if (preg_match($chars, $strEmail)) {
                        return $strEmail;
                } else {
                        return FALSE;
                }
        } else {
                return FALSE;
        }
}

function antiinjection2($str) {
	$banwords = array ("'", ",", ";", "--");
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( $banwords, '', strtolower ( $str ) );
	} else {
		$str = NULL;
	}
	return $str;
}

function checkcookie($where, $cookieuser, $cookiepass, $dbname, $sqladdress, $sqluser, $sqlpass) {
	$cookieuser=antiinjection($cookieuser);
	$cookiepass=antiinjection($cookiepass);
	$conn = connectdb($dbname,$sqladdress, $sqluser, $sqlpass);
	if($where==0) {
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		// echo sprintf(SELECT_USER_PASS, $cookieuser);
		// $result = sqlsrv_query($conn, sprintf(SELECT_USER_PASS, $cookieuser),$params, $options);
		// $result = sqlsrv_query($conn, sprintf(SELECT_USER_PASS, $cookieuser));
		// $rows=sqlsrv_num_rows($result);

		// echo '
		// <script language="JavaScript">
		// console.log("xD'. $rows . '");
		// </script>
		// ';
		// if ($rows>0) {
		// 	$rows=mssql_fetch_assoc($result); 
		// 	extract($rows);
		// 	$password = '0x' . bin2hex($password);
		// 	if(md5($password)==$cookiepass) {
		// 		quickrefresh('home.php');
		// 	} else {
		// 		resetcookies();
		// 	}
		// } else {
		// resetcookies();
		// }
	} elseif($where==1) {
		// $result = sqlsrv_query($conn, sprintf(SELECT_USER_PASS, $cookieuser));
		// $rows=mssql_num_rows($result);
		// if ($rows>0) {
		// 	$rows=mssql_fetch_assoc($result); 
		// 	extract($rows);
		// 	$password = '0x' . bin2hex($password);
		// 	if(md5($password)!=$cookiepass) {
		// 		notloggedin();
		// 	}
		// } else {
		// 	notloggedin();
		// }
	}
}

function connectdb($db, $serverName, $dbuser, $dbpass) {

	$connectionInfo = array( "Database"=> $db, "UID"=> $dbuser, "PWD"=>$dbpass); 
	$conn =sqlsrv_connect( $serverName, $connectionInfo);
    
	if( $conn ) {
		// echo "Connection established.<br />";
	// 	$stmt = sqlsrv_query($conn, sprintf(SELECT_USER_PASS,'teste')) or die(sqlsrv_errors());
	// 	while( $rows = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	// 		echo $rows['account'].", ".$rows['password']."<br />";
	//   }
   }else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));

   }
   return $conn;
}



function delayedrefresh($page) {
	echo "<meta http-equiv='refresh' content='3; URL={$page}'>";
}

function echoindex($part) {
	if($part=='credits') {
		// $copyright = isset($CONFIG['servername']);
	echo '
	<tr valign="top">
		<td width="100%" align="center">
			<table width="703" border="0" cellpadding="0">
    				<tr> 
     					<td width="700" height="15" style="background: url(images/header.gif);" class="header">
						<center>
							:: Credits  ::
						</center>
					</td>
				</tr>
				<tr> 
					<td style="border-left:1px solid black;border-right:1px solid black;" class="normal">
						<div style="margin: 10px;" align="center">
						Copyright 2023, Lineage II Control Panel.
						<br />
						</div>
     					</td>
    				</tr>
    				<tr> 
     					<td style="background: url(images/footer.gif);" height="15">
					</td>
    				</tr>
   			</table>
		</td>
	</tr>
	';
	} elseif($part=='end') {
	echo '
	</table>
	</body>
	';
	} elseif($part=='head') {
	echo '
	<table width="703" align="center" border="0" cellpadding="0">
	<tr>
		<td height="96">
			<center>
				<img src="images/title.jpg" border="0" alt="" />
			</center>
		</td>
	</tr>
	';
	} elseif($part=='space') {
	echo '
	<tr>
		<td class="normal">
			&nbsp;
		</td>
	</tr>
	';
	} elseif($part=='title') {
	echo "
	<title>
		Lineage II Control Panel
	</title>
	<link href='img/styles.css' rel='stylesheet' type='text/css'>
	<body bgcolor='#B2CAFA' topmargin='0' leftmargin='0' rightmargin='0'>
	";
	}
}

function echopage($part, $title) {
	if($part=='footer') {
	echo "
						</div>
     					</td>";

			if (isset($CONFIG['onlineusers'])=="1") {
				echo "
					<td style='border-left:1px solid black;border-right:1px solid black;' class='normal' valign='top'>
						<div style='margin: 10px;'>";
		if ($CONFIG['savetxt']=="1") {
			$online["cache"] = @file("temp/online.txt");
			@list($online["last"]["check"], $online["last"]["online"]) = explode(";", $online["cache"][0]);
		}

		if($online["last"]["check"] == "" || $online["last"]["check"] < (time() - 240)) {
		mssql_select_db("lin2db");
		$mssql["entry"] = mssql_fetch_array(mssql_query("SELECT TOP 1 world_user FROM user_count WHERE server_id < 2 ORDER BY record_time DESC;"));
		$online["online"] = $mssql["entry"]["world_user"];
		$online["online"] = $online["online"];
		echo "<font face=\"verdana\" size=\"2\"><b>Online:</b>&nbsp;&nbsp;".$online["online"]."</font><br />";

		if ($CONFIG['savetxt']=="1") {
			$f = fopen("temp/online.txt", "w");
			fputs($f, time().";".$online["online"]);
			fclose($f);
		}

		} else {
			$online["last"]["online"] = $online["last"]["online"];
			echo "<font face=\"verdana\" size=\"2\"><b>Online:&nbsp;&nbsp;".$online["last"]["online"]."</font><br />";
		}
	echo "
						</div>
     					</td>";
     			}
    echo "
    				</tr>
    				<tr> 
     					<td style=\"background: url(images/footer.gif);\" height='15'>
					</td>
     					<td style=\"background: url(images/footer.gif);\" height='15'>
					</td>
    				</tr>
   			</table>
		</td>
	</tr>
	";
	} elseif($part=='header') {
	echo "
	<tr valign=\"top\">
	<td width=\"100%\" align=\"center\">
		<table width=\"703\" border=\"0\" cellpadding=\"0\">
    			<tr> 
     				<td width=\"700\" height=\"15\" style=\"background: url(images/header.gif);\" class=\"header\">
					<center>
						:: {$title} ::
					</center>
				</td>";
			if (isset($CONFIG['onlineusers'])=="1") {
				echo "
				<td width=\"200\" height=\"15\" style=\"background: url(images/header.gif);\" class=\"header\">
					<center>
						:: Statistics ::
					</center>
				</td>";
			}
	echo "
			</tr>
			<tr> 
				<td style='border-left:1px solid black;border-right:1px solid black;' class='normal'>
					<div style='margin: 10px;'>
	";

	}
}

function encrypt($str) {
	$key = array();
	$dst = array();
	$i = 0;

	$nBytes = strlen($str);
        	while ($i < $nBytes){
               	 $i++;
                	$key[$i] = ord(substr($str, $i - 1, 1));
                	$dst[$i] = $key[$i];
	}  

	$rslt = $key[1] + $key[2]*256 + $key[3]*65536 + $key[4]*16777216;
	$one = $rslt * 213119 + 2529077;
	$one = $one - intval($one/ 4294967296) * 4294967296;

	$rslt = $key[5] + $key[6]*256 + $key[7]*65536 + $key[8]*16777216;
	$two = $rslt * 213247 + 2529089;
	$two = $two - intval($two/ 4294967296) * 4294967296;

	$rslt = $key[9] + $key[10]*256 + $key[11]*65536 + $key[12]*16777216;
	$three = $rslt * 213203 + 2529589;
	$three = $three - intval($three/ 4294967296) * 4294967296;

	$rslt = $key[13] + $key[14]*256 + $key[15]*65536 + $key[16]*16777216;
	$four = $rslt * 213821 + 2529997;
	$four = $four - intval($four/ 4294967296) * 4294967296;

	$key[4] = intval($one/16777216);        
	$key[3] = intval(($one - $key[4] * 16777216) / 65535);
	$key[2] = intval(($one - $key[4] * 16777216 - $key[3] * 65536) / 256);
	$key[1] = intval(($one - $key[4] * 16777216 - $key[3] * 65536 - $key[2] * 256));

	$key[8] = intval($two/16777216);     
	$key[7] = intval(($two - $key[8] * 16777216) / 65535);
	$key[6] = intval(($two - $key[8] * 16777216 - $key[7] * 65536) / 256);
	$key[5] = intval(($two - $key[8] * 16777216 - $key[7] * 65536 - $key[6] * 256));

	$key[12] = intval($three/16777216);     
	$key[11] = intval(($three - $key[12] * 16777216) / 65535);
	$key[10] = intval(($three - $key[12] * 16777216 - $key[11] * 65536) / 256);
	$key[9] = intval(($three - $key[12] * 16777216 - $key[11] * 65536 - $key[10] * 256));

	$key[16] = intval($four/16777216);     
	$key[15] = intval(($four - $key[16] * 16777216) / 65535);
	$key[14] = intval(($four - $key[16] * 16777216 - $key[15] * 65536) / 256);
	$key[13] = intval(($four - $key[16] * 16777216 - $key[15] * 65536 - $key[14] * 256));

	$dst[1] = $dst[1] ^ $key[1];

	$i=1;
	while ($i<16){
		$i++;
		$dst[$i] = $dst[$i] ^ $dst[$i-1] ^ $key[$i];
	}

	$i=0;
	while ($i<16){
		$i++;
		if ($dst[$i] == 0) {
			$dst[$i] = 102;
		}
	}

	$encrypt = "0x";
	$i=0;
	while ($i<16){
		$i++;
		if ($dst[$i] < 16) {
			$encrypt = $encrypt . "0" . dechex($dst[$i]);
		} else {
			$encrypt = $encrypt . dechex($dst[$i]);
		}
	}

	return $encrypt;
}

function nocache() {
	echo '
	<META HTTP-EQUIV="Pragma" CONTENT="No-Cache">
	<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache,Must-Revalidate,No-Store">
	<META HTTP-EQUIV="Expires" CONTENT="-1">
	<META HTTP-EQUIV="ImageToolbar" CONTENT="No">
	<META NAME="MSSmartTagsPreventParsing" CONTENT="True">
	';
}

function notloggedin() {
	resetcookies();
	echo '
		<script type="text/javascript">
		alert("You are not logged in.");
		</script>
	';
	quickrefresh('index.php');
}

function quickrefresh($page) {
	echo "<meta http-equiv='refresh' content='0; URL={$page}'>";
	exit();
}

function resetcookies() {
	setcookie ("user", "", time()-2592000);
	setcookie ("pass", "", time()-2592000);
}

function securitycheck($securitycheck) {
	if($securitycheck!=1) {
		quickrefresh('index.php');
		exit();
	}
}

function sendemail($emailsmtp, $emailuser, $emailpass, $selfemail, $servername, $subject, $email, $username, $password, $ssn, $success) {
	require("phpmailer/class.phpmailer.php");

	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->Host     = $emailsmtp;
	$mail->SMTPAuth = true;
	$mail->Username = $emailuser;
	$mail->Password = $emailpass;

	$mail->From     = $selfemail;
	$mail->FromName = $servername;
	$mail->AddAddress($email,$username); 

	$mail->Subject  =  $servername . " " . $subject;
	$mail->Body     =  "Your account information has been listed below...

Username: {$username}
Password: {$password}
SSN: {$ssn}

-----------------------------------------------------------------------------
{$servername} Admin";

	if(!$mail->Send()) {
		echo "Email has not been sent due to an error.<br />";
		echo "<br /><br />";
	} else {
		echo $success . "<br /><br />";
	}

}
?>