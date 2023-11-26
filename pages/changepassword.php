<?php
securitycheck($securitycheck);

$error = 0;

echopage('header', 'Change Password');

echo '
<script>
function isAlphaNumeric(value) {
	if (value.match(/^[a-zA-Z0-9]+$/)) {
		return true;
	} else {
		return false;
	}	
}

function checkform() {
	if(changepassword.oldpassword.value=="") { 
		alert("Please enter your old password.") 
		return false; 
	}
	if(changepassword.newpassword.value=="") { 
		alert("Please enter a new password.") 
		return false; 
	}
	if (!isAlphaNumeric(changepassword.newpassword.value)) {
		alert("Your new password must be alphanumeric!");
		return false;
	}
	if(changepassword.newpassword2.value=="") { 
		alert("Retype your new password.") 
		return false; 
	}
	if(changepassword.oldpassword.value==changepassword.newpassword.value) { 
		alert("Old password cannot be the same as new password.") 
		return false; 
	}
return true;
}
</script>
';

if($_POST['action']=='changepassword') {

	$error = 2;

	connectdb($CONFIG['dbdbname'], $CONFIG['dbaddress'], $CONFIG['dbuser'], $CONFIG['dbpass']);

	$username = $_COOKIE['user'];
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$newpassword2 = $_POST['newpassword2'];
	$username = antiinjection($username);
	$oldpassword = antiinjection($oldpassword);
	$newpassword = antiinjection($newpassword);
	$newpassword2 = antiinjection($newpassword2);

	echo "<div align=center>";

	$result = mssql_query (sprintf(SELECT_USER_PASS, $username));
	$rows=mssql_fetch_assoc($result); 
	extract($rows);

	$password = '0x' . bin2hex($password);
	$oldpassword = encrypt($oldpassword);

	if ($password!=$oldpassword) {
		echo "Old password is incorrect.<br />";
		$error = 1;
	}

	if ((strlen($newpassword)<4 ||strlen($newpassword)>16) && $newpassword!="") {
		echo "Password length must be 4 to 16 characters long.<br />";
		$error = 1;
	}
	if ($newpassword!=$newpassword2) {
		echo "Retyped password is incorrect.<br />";
		$error = 1;
	}
	

	echo "</div>";

}

if($error<2) {
	echo "
	<form name=\"changepassword\" action=\"home.php?page=changepassword\" method=\"post\" onsubmit=\"return checkform()\">
		<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td align=\"right\">
					Old Password: 
				</td>
				<td width=\"150\" align=\"right\">
						<input type=\"password\" class=\"post\" maxlength=\"16\" name=\"oldpassword\">
				</td>
			</tr>
			<tr>
				<td align=\"right\">
					New Password: 
				</td>
				<td width=\"150\" align=\"right\">
						<input type=\"password\" class=\"post\" maxlength=\"16\" name=\"newpassword\">
				</td>
			</tr>
			<tr>
				<td align=\"right\">
					Retype New Password: 
				</td>
				<td width=\"150\" align=\"right\">
						<input type=\"password\" class=\"post\" maxlength=\"16\" name=\"newpassword2\">
				</td>
			</tr>
		</table>
		<div align=\"center\">
			<br />
			<input type=\"hidden\" name=\"action\" value=\"changepassword\">
			<input type=\"submit\" class=\"mainoption\" name=\"submit\" value=\"Submit\">
			<input type=\"reset\" class=\"mainoption\" name=\"reset\" value=\"Reset\">
		</div>
	</form>
	";
}

if($error==2) {

$newpassword = encrypt($newpassword);
mssql_query(sprintf(UPDATE_PASSWORD, $newpassword, $account));

echo '
<div align=center>
<strong>Password has been successfully changed.</strong><br /><br />
You will be redirected to the login page in 3 seconds or you can click <a href="home.php?page=logout">here</a>.
</div>
';
delayedrefresh('home.php?page=logout');

}

echopage('footer', '');


?>
