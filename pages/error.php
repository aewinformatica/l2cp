<?php
echopage('header', 'Login');
echo '
<script>
function checkform() {
	if(login.username.value=="") { 
		alert("Please enter your account name.") 
		return false; 
	}
	if(login.password.value=="") { 
		alert("Please enter your password.") 
		return false; 
	}
return true;
}
</script>
	<form name="login" action="login.php" method="post" onSubmit="return checkform()" style="margin: 0px;">
		<table cellspacing=0 border=0 cellpadding=0 align=center>
			<tr>
				<td width=100>
					Username
				</td>
				<td>
					<div align=right>
						<input name="username" type="text" class="normal" size="16" maxlength="14">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					Password
				</td>
				<td>
					<div align=right>
						<input name="password" type="password" class="normal" size="16" maxlength="16">
					</div>
				</td>
			</tr>
		</table>
		<div align=center>
			<br>
			<input type="hidden" name="action" value="login">
			<input type="image" name="submit" src="images/login.jpg" value="submit" class="normal">&nbsp;
			<a href="index.php?page=register"><img src="images/register.jpg" border="0"></a>&nbsp;
			<a href="index.php?page=lostpassword"><img src="images/lostpassword.jpg" border="0"></a>
		</div>
	</form>
';
echopage('footer', '');
?>