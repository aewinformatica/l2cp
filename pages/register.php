<?php
securitycheck($securitycheck);
$accounttxt = "<font color=\"black\">Account Name:<br />";
	$passwordtxt = "<font color=\"black\">Password:<br />";
	$password2txt = "<font color=\"black\">Re-type Password:<br />";
	$emailtxt = "<font color=\"black\">E-mail Address:<br />";
	$question1txt = "<font color=\"black\">Security Question #1:<br />";
	$answer1txt = "<font color=\"black\">Security Answer #1:<br />";
	$question2txt = "<font color=\"black\">Security Question #2:<br />";
	$answer2txt = "<font color=\"black\">Security Answer #2:<br />";

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
}else{
	$securitycode = "";
}

$conn =  connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);
$result = sqlsrv_query($conn, sprintf(SELECT_COUNT_ACCOUNT));
$accounts = sqlsrv_fetch_array($result);
$accounts = $accounts[0];

if($CONFIG['maxaccounts']==0) {
	$maxaccounts = 0;
} elseif($accounts>=$CONFIG['maxaccounts']) {
	$maxaccounts = 1;
} else {
	$maxaccounts = 0;
}

if($maxaccounts==0) {

if($CONFIG['registration']==1) {

$error = 0;
echopage('header', 'Register');
?>
<script type="text/javascript">
function isEmailAddress(email) {
	if (email.match(/^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/)) {
		return true;
	} else {
		return false;
	}	
}

function isAlphaNumeric(value) {
	if (value.match(/^[a-zA-Z0-9]+$/)) {
		return true;
	} else {
		return false;
	}	
}

function checkform() {
	if(register.account.value=="") { 
		alert("Please enter an account name.") 
		return false; 
	}
	if (!isAlphaNumeric(register.account.value)) {
		alert("Your username must be alphanumeric!");
		return false;
	}
	if(register.password.value=="") { 
		alert("Please enter a password.") 
		return false; 
	}
	if (!isAlphaNumeric(register.password.value)) {
		alert("Your password must be alphanumeric!");
		return false;
	}
	if(register.password2.value=="") { 
		alert("Retype your password.") 
		return false; 
	}
	if(register.email.value=="") { 
		alert("Please enter your email.") 
		return false; 
	}
	if (!isEmailAddress(register.email.value)) {
		alert("You did not enter a valid email address!");
		return false;
	}
	if(register.question1.value=="") { 
		alert("Please enter your security question #1.") 
		return false; 
	}
	if(register.answer1.value=="") { 
		alert("Please enter the answer to your security question #1.") 
		return false; 
	}
	if(register.question2.value=="") { 
		alert("Please enter your security question #2.") 
		return false; 
	}
	if(register.answer2.value=="") { 
		alert("Please enter the answer to your security question #2.") 
		return false; 
	}
return true;
}
</script>

<?php

if($_POST['register']=='register') {

	$error = 2;

	$conn = connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);

	$account = $_POST['account'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];
	$question1 = $_POST['question1'];
	$answer1 = $_POST['answer1'];
	$question2 = $_POST['question2'];
	$answer2 = $_POST['answer2'];
	$account = antiinjection($account);
	$password = antiinjection($password);
	$password2 = antiinjection($password2);
	$email = isEmailAddress($email);
	$question1 = antiinjection($question1);
	$answer1 = antiinjection($answer1);
	$question2 = antiinjection($question2);
	$answer2 = antiinjection($answer2);
	$accounttxt = "<font color=\"blue\">Account Name:<br />";
	$passwordtxt = "<font color=\"blue\">Password:<br />";
	$password2txt = "<font color=\"blue\">Re-type Password:<br />";
	$emailtxt = "<font color=\"blue\">E-mail Address:<br />";
	$question1txt = "<font color=\"blue\">Security Question #1:<br />";
	$answer1txt = "<font color=\"blue\">Security Answer #1:<br />";
	$question2txt = "<font color=\"blue\">Security Question #2:<br />";
	$answer2txt = "<font color=\"blue\">Security Answer #2:<br />";
			
	echo "<div align=\"center\">";

	if ($account=="") {
		$accounttxt = "<font color=\"red\">Account Name:<br />";
		$error = 1;
	}
	
	if ($password=="") {
		$passwordtxt = "<font color=\"red\">Password:<br />";
		$error = 1;
	}
	
	if ($password2=="") {
		$password2txt = "<font color=\"red\">Re-type Password:<br />";
		$error = 1;
	}
	
	if ($email=="") {
		$emailtxt = "<font color=\"red\">E-mail Address:<br />";
		$error = 1;
	}
	
	if ($question1=="") {
		$question1txt = "<font color=\"red\">Security Question #1:<br />";
		$error = 1;
	}
	
	if ($answer1=="") {
		$answer1txt = "<font color=\"red\">Security Answer #1:<br />";
		$error = 1;
	}
	
	if ($question2=="") {
		$question2txt = "<font color=\"red\">Security Question #2:<br />";
		$error = 1;
	}
	if ($answer2=="") {
		$answer2txt = "<font color=\"red\">Security Answer #2:<br />";
		$error = 1;
	}
	
	$result = sqlsrv_query ($conn, sprintf(CHECK_ACCOUNT, $account));
	$rows=sqlsrv_num_rows($result);

	if ($rows>0) {
		echo "<font color=\"red\">Account already exist.<br />";
		$accounttxt = "<font color=\"red\">Account Name:<br />";
		$error = 1;
	}
	
	if ((strlen($account)<4 || strlen($account)>14)&& $account!="") {
		echo "<font color=\"red\">Account length must be 4 to 14 characters long.<br />";
		$accounttxt = "<font color=\"red\">Account Name:<br />";
		$error = 1;
	}
	
	if ((strlen($password)<4 ||strlen($password)>16) && $password!="") {
		echo "<font color=\"red\">Password length must be 4 to 16 characters long.<br />";
		$passwordtxt = "<font color=\"red\">Password:<br />";
		$error = 1;
	}
	if ($password!=$password2) {
		echo "<font color=\"red\">Re-typed password is incorrect.<br />";
		$password2txt = "<font color=\"red\">Re-type Password:<br />";
		$error = 1;
	}

	$result = sqlsrv_query ($conn, sprintf(CHECK_EMAIL, $email));
	$rows=sqlsrv_num_rows($result);

	if ($CONFIG['maxemail']>0) {
		if ($rows>=$CONFIG['maxemail']) {
			echo "<font color=\"red\">The maximum accounts per email are {$CONFIG['maxemail']}.<br />";
			$emailtxt = "<font color=\"red\">E-mail Address:<br />";
			$error = 1;
		}
	}

	if ((strlen($email)<7 ||strlen($email)>50) && $email!="") {
		echo "<font color=\"red\">E-mail length must be 7 to 50 characters long.<br />";
		$emailtxt = "<font color=\"red\">E-mail Address:<br />";
		$error = 1;
	}
	if ((strlen($question1)<4 ||strlen($question1)>250) && $question1!="") {
		echo "<font color=\"red\">Security Question #1 length must be 4 to 250 characters long.<br />";
		$question1txt = "<font color=\"red\">Security Question #1:<br />";
		$error = 1;
	}
	if (strlen($answer1)>16 && $answer1!="") {
		echo "<font color=\"red\">Security Answer #1 length must be 1 to 16 characters long.<br />";
		$answer1txt = "<font color=\"red\">Security Answer #1:<br />";
		$error = 1;
	}
	if ((strlen($question2)<4 ||strlen($question2)>250) && $question2!="") {
		echo "<font color=\"red\">Security Question #2 length must be 4 to 250 characters long.<br />";
		$question2txt = "<font color=\"red\">Security Question #2:<br />";
		$error = 1;
	}
	if (strlen($answer2)>16 && $answer2!="") {
		echo "<font color=\"red\">Security Answer #2 length must be 1 to 16 characters long.<br />";
		$answer2txt = "<font color=\"red\">Security Answer #2:<br />";
		$error = 1;
	}
	
if ($CONFIG['securitycode']=="1" || $CONFIG['securitycode']=="2") {
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
		echo "<font color=\"red\">Incorrect Security Code.<br />";
		$error = 1;
	}
}

	echo "</div>";
	
}


if($error<2) {
	echo "
	<form name=\"register\" action=\"index.php?page=register\" method=\"post\" onsubmit=\"return checkform()\">
		<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td align=\"right\">";
					echo ($accounttxt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"14\" name=\"account\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($passwordtxt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"password\" class=\"post\" maxlength=\"16\" name=\"password\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($password2txt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"password\" class=\"post\" maxlength=\"16\" name=\"password2\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($emailtxt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"50\" name=\"email\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($question1txt);
					echo "
					
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"250\" name=\"question1\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($answer1txt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"16\" name=\"answer1\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($question2txt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"250\" name=\"question2\" />
				</td>
			</tr>
			<tr>
				<td align=\"right\">";
					echo ($answer2txt);
					echo "
				</td>
				<td width=\"150\" align=\"right\">
					<input type=\"text\" class=\"post\" maxlength=\"16\" name=\"answer2\" />
				</td>
			</tr>
			$securitycode
		</table>
		<div align=\"center\">
			<br />
			<input type=\"hidden\" name=\"register\" value=\"register\" />
			<input type=\"submit\" name=\"submit\" class=\"mainoption\" value=\"Submit\" />
			<input type=\"reset\" name=\"reset\" class=\"mainoption\" value=\"Reset\" />
		</div>
	</form>
	";
}

if($error==2) {

$ssn1 = mt_rand(1000000,9999999);
$ssn2 = mt_rand(100000,999999);
$ssn = $ssn1 . $ssn2;
$password = encrypt($password);
$answer1= encrypt($answer1);
$answer2= encrypt($answer2);

sqlsrv_query($conn, sprintf(INSERT_SSN, $ssn, $account, $email));
sqlsrv_query($conn, sprintf(INSERT_USERACCOUNT, $account));
sqlsrv_query($conn, sprintf(INSERT_USERINFO, $account, $ssn));
sqlsrv_query($conn, sprintf(INSERT_USERAUTH, $account, $password, $question1, $question2, $answer1, $answer2));

echo "
<div align=center>
<strong>Account has been created sucessfully!</strong><br /><br />
";
if($CONFIG['displayssn']==1) {
	echo "
	A social security number (SSN) has been randomly generated for you.<br />
	{$ssn}<br /><br />
	";
}
echo '
</div>
';

}

echopage('footer', '');

} elseif($CONFIG['registration']==0) {
echopage('header', 'Register');
echo '<center>Registration has been disabled.</center>';
echopage('footer', '');
}

} elseif($maxaccounts==1) {
echopage('header', 'Register');
echo "<center>Maximum account limit of {$CONFIG['maxaccounts']} has been reached.</center>";
echopage('footer', '');
}

?>
