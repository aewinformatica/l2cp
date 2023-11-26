<?php
securitycheck($securitycheck);

if ($CONFIG['securitycode']=="1") {
	$securitycode = "
			<tr>
				<td width=\"100\">Security Code:</td>
				<td><input name=\"vercode\" type=\"text\" class=\"post\" size=\"16\" maxlength=\"14\" /></td>
			</tr>
			<tr>
				<td align=\"right\"><img src=\"load/captcha.php\" width=\"60\" height=\"30\" alt=\"Security Code\" /></td>
				<td></td>
			</tr>
";
}else{
	$securitycode = "";
}

echopage('header', 'Login');
echo "
<script type=\"text/javascript\">
function isAlphaNumeric(value) {
	if (value.match(/^[a-zA-Z0-9]+$/)) {
		return true;
	} else {
		return false;
	}	
}

function checkform() {
	if(login.username.value==\"\") { 
		alert(\"Please enter your account name.\") 
		return false; 
	}
	if(login.password.value==\"\") { 
		alert(\"Please enter your password.\") 
		return false; 
	}
	if (!isAlphaNumeric(login.username.value)) {
		alert(\"Your username must be alphanumeric!\");
		return false;
	}
	if (!isAlphaNumeric(login.password.value)) {
		alert(\"Your password must be alphanumeric!\");
		return false;
	}
return true;
}
</script>
	<form name=\"login\" action=\"index.php?page=login\" method=\"post\" onsubmit=\"return checkform()\" style=\"margin: 0px;\">
		<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" align=\"center\">
			<tr>
				<td width=\"100\">
					Username: 
				</td>
				<td>
					<div align=\"right\">
						<input name=\"username\" type=\"text\" class=\"post\" size=\"16\" maxlength=\"14\" />
					</div>
				</td>
			</tr>
			<tr>
				<td width=\"100\">
					Password: 
				</td>
				<td>
					<div align=\"right\">
						<input name=\"password\" type=\"password\" class=\"post\" size=\"16\" maxlength=\"16\" />
					</div>
				</td>
			</tr>
				$securitycode
		</table>

		<div align=\"center\">
			<br />
			<input type=\"hidden\" name=\"action\" value=\"login\" />
			<input type=\"submit\" name=\"submit\" value=\"Login\" class=\"mainoption\" />&nbsp;
			<input type=\"reset\" name=\"reset\" value=\"Reset\" class=\"mainoption\" />
			<br />
			<br />
			<a href=\"index.php?page=register\">Register an account</a>&nbsp; | &nbsp;
			<a href=\"index.php?page=lostpassword\">Forgot your password?</a>
		</div>
	</form>
";
echopage('footer', '');
?>