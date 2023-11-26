<?php
/*Server Name				[Default: L2 Server]*/
$CONFIG['servername'] = "L2 Server";	

/*SQL IP Address			[Default: 127.0.0.1]*/
$CONFIG['dbaddress'] = "DESKTOP-VHUENEA\SQLEXPRESS";

/*SQL Username				[Default: sa]*/
$CONFIG['dbuser'] = "sa";

/*SQL Password				[Default: NULL]*/
$CONFIG['dbpass'] = "yourpass";

/*Lineage II Database Database Name	[Default: lin2db]*/
$CONFIG['dbdbname'] = "lin2db";

/*Lineage II World Database Name	[Default: lin2world]	*/
$CONFIG['worlddbname'] = "lin2world";

/*Enable Registration			[Default: 1]*/
$CONFIG['registration'] = "1";

/*Message Disabled Registration		[Default: Registration temporarely has been disabled.]*/
$CONFIG['registrationreason'] = "Registration temporarely has been disabled.";

/*Enable CP				[Default: 1]*/
$CONFIG['cp'] = "1";

/*Message Disabled CP			[Default: Control Panel has been disabled.]*/
$CONFIG['cpreason'] = "Control Panel has been disabled.";

/*Announcement Message			[Default: Control Panel is still under construction.]*/
$CONFIG['announcement'] = "Control Panel is still under construction.";

/*Security codes on/off			[Default: 0 (disabled), 1: enabled for all, 2: enabled for all except login]*/
$CONFIG['securitycode'] = "0";

/*Enable/Disable Online User		[Default: 0 (disabled), 1: enabled for all, 2: only enabled for home.php]*/
//  Nicht werken! 
 $CONFIG['onlineusers'] = "2";

/*Save Online User in temp/online.txt	[Default: 0 (disabled), 1: enabled]*/
/* Nicht werken! $CONFIG['savetxt'] = "0";*/
$CONFIG['savetxt'] = "1";

/*Maximum Account Limit			[Default: 0 (0 for unlimited)]*/
$CONFIG['maxaccounts'] = "0";

/*Maximum Accounts Per Email		[Default: 1 (0 for unlimited)]*/
$CONFIG['maxemail'] = "1";

/*Display SSN at End of Registration	[Default: 1]*/
$CONFIG['displayssn'] = "0";

/*Enable Email Functions		[Default: 1]*/
$CONFIG['email'] = "0";

/*Server Reply Email Address		[Default: NULL]*/
$CONFIG['emailaddress'] = "";

/*SMTP Server for Sending Emails	[Default: NULL]*/
$CONFIG['emailsmtp'] = "";

/*Username for SMTP server		[Default: NULL]*/
$CONFIG['emailuser'] = "";

/*Password for SMTP server		[Default: NULL]*/
$CONFIG['emailpass'] = "";
?>