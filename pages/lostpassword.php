<?php
securitycheck($securitycheck);
$error = 1;

if ($CONFIG['securitycode']=="1" || $CONFIG['securitycode']=="2") {
	$securitycode = "
			<tr>
				<td align=\"right\">
					Security Code: 
				</td>
				<td width=\"150\" align=\"right\">
					<input name=\"vercode\" type=\"text\" class=\"post\" maxlength=\"5\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\"><img src=\"load/captcha.php\" width=\"60\" height=\"30\" alt=\"Security Code\" /></td>
				<td></td>
			</tr>
";
	$securitycode2 = "
	<tr>
		<td>
			Security Code: 
		</td>
		<td>
			<div align=\"right\">
			<input name=\"vercode\" type=\"text\" class=\"post\" maxlength=\"5\" />
			</div>
		</td>
	</tr>
	<tr>
		<td align=\"right\"><img src=\"load/captcha.php\" width=\"60\" height=\"30\" alt=\"Security Code\" /></td>
		<td></td>
	</tr>
";
}else{
	$securitycode = "";
}

echopage('header', 'Lost Password?');

echo '
<script type="text/javascript">
function isAlphaNumeric(value) {
	if (value.match(/^[a-zA-Z0-9]+$/)) {
		return true;
	} else {
		return false;
	}	
}

function checkform1() {
	if(lostpassword.account.value=="") { 
		alert("Please enter an account name.") 
		return false; 
	}
	if (!isAlphaNumeric(lostpassword.account.value)) {
		alert("Your account name must be alphanumeric!");
		return false;
	}
return true;
}

function checkform2() {
	if(lostpassword.answer1.value=="") { 
		alert("Please enter the answer to your security question #1.") 
		return false; 
	}
	if(lostpassword.answer2.value=="") { 
		alert("Please enter the answer to your security question #2.") 
		return false; 
	}
return true;
}
</script>
';

echo '<center>';

if($_POST['lostpassword']=='account') {

	connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);

	$postusername = $_POST['account'];
	$postusername = antiinjection($postusername);

	$result = mssql_query (sprintf(SELECT_USER_FULLINFO, $postusername));
	$rows=mssql_num_rows($result);

	if($rows>0) {
		$rows=mssql_fetch_assoc($result); 
		extract($rows);
		$error = 2;
	} else {
		echo "Account doesn't exist.<br />";
		$error = 1;
	}

if ($CONFIG['securitycode']=="1" || $CONFIG['securitycode']=="2") {
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
		echo "Incorrect verification code.<br />";
		$error = 1;
	}
		
}
}

if($_POST['lostpassword']=='email') {

	$error = 3;

	$postusername = $_POST['account'];
	$postanswer1 = $_POST['answer1'];
	$postanswer2 = $_POST['answer2'];
	$postusername = antiinjection($postusername);
	$postanswer1 = antiinjection($postanswer1);
	$postanswer2 = antiinjection($postanswer2);

	connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);

	$result = mssql_query (sprintf(SELECT_USER_FULLINFO, $postusername));
	$rows=mssql_num_rows($result);

	if($rows>0) {
		$rows=mssql_fetch_assoc($result); 
		extract($rows);

		$postanswer1 = encrypt($postanswer1);
		$postanswer2 = encrypt($postanswer2);
		$answer1 = '0x' . substr(bin2hex($answer1), 0, 32);
		$answer2 = '0x' . substr(bin2hex($answer2), 0, 32);
		
		if($answer1!=$postanswer1) {
			echo "Answer to security question #1 is incorrect.<br />";
			$error = 2;
		}
		if($answer2!=$postanswer2) {
			echo "Answer to security question #2 is incorrect.<br />";
			$error = 2;
		}
	} else {
		echo "Account doesn't exist.<br />";
		$error = 1;
	}

if ($CONFIG['securitycode']=="1" || $CONFIG['securitycode']=="2") {	
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
		echo "Incorrect verification code.<br />";
		$error = 1;
	}

}
}

if($error==1) {
echo "
<form name='lostpassword' action='index.php?page=lostpassword' method='post' onsubmit='return checkform1()'>
		<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td>
					Account name: 
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"14\" name=\"account\" />
				</td>
			</tr>
			$securitycode
		</table>
		<div align=\"center\">
			<br />
			<input type=\"hidden\" name=\"lostpassword\" value=\"account\" />
			<input type=\"submit\" class=\"mainoption\" name=\"login\" value=\"Submit\" />
			<input type=\"reset\" class=\"mainoption\" name=\"reset\" value=\"Reset\" />
			<br />
			<br />
			<a href=\"index.php?page=register\">Register an account</a>&nbsp; | &nbsp;
			<a href=\"index.php?page=lostpassword\">Forgot your password?</a>
		</div>
	</form>
";
}

if($error==2) {
echo "
<form name='lostpassword' action='index.php?page=lostpassword' method='post' onsubmit='return checkform2()'>
		<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" align=\"center\">
	<tr>
		<td  width=\"200\">
			Security Question #1: 
		</td>
		<td>
			<div align=\"right\">
				{$quiz1}
			</div>
		</td>
	</tr>
	<tr>
		<td>
			Security Answer #1: 
		</td>
		<td>
			<div align=\"right\">
				<input type=\"text\" class=\"post\" maxlength=\"32\" name=\"answer1\">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			Security Question #2: 
		</td>
		<td>
			<div align=\"right\">
				{$quiz2}
			</div>
		</td>
	</tr>
	<tr>
		<td>
			Security Answer #2: 
		</td>
		<td>
			<div align=\"right\">
				<input type=\"text\" class=\"post\" maxlength=\"32\" name=\"answer2\">
			</div>
		</td>
	</tr>
	$securitycode2
	</table>
	<div align=\"center\">
		<br />
		<input type=\"hidden\" name=\"lostpassword\" value=\"email\">
		<input type=\"hidden\" name=\"account\" value=\"{$postusername}\">
		<input type=\"submit\" class=\"mainoption\" name=\"login\" value=\"Submit\">
		<input type=\"reset\" class=\"mainoption\" name=\"reset\" value=\"Reset\">
		<br />
		<br />
		<a href=\"index.php?page=register\">Register an account</a>&nbsp; | &nbsp;
		<a href=\"index.php?page=lostpassword\">Forgot your password?</a>
	</div>
</form>
";
}

if($error==3) {

	$newpassword = mt_rand(1000000,9999999);
	$newpassword = md5($newpassword);
	$newpassword = substr($newpassword, 0, 15);
	$encnewpassword = encrypt($newpassword);
	echo '<br />';

	mssql_query(sprintf(UPDATE_PASSWORD, $encnewpassword, $account));

	if($CONFIG['email']==0) {
		echo "<strong>Your password has been reseted to...</strong><br />{$newpassword}<br /><br />";
	} elseif($CONFIG['email']==1) {
		sendemail($CONFIG['emailsmtp'], $CONFIG['emailuser'], $CONFIG['emailpass'], $CONFIG['emailaddress'], $CONFIG['servername'], "Lost Password", $email, $account, $newpassword, $ssn, "<strong>Your password has been reseted and sent to your email.</strong>");
	}

}

echo '</center>';

echopage('footer', '');

?>