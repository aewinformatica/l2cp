<?php
securitycheck($securitycheck);
echopage('header', 'Announcements');
echo "
<b>Welcome to {$CONFIG['servername']} Lineage II Control Panel.</b>
<br /><br />
{$CONFIG['announcement']}
";
echopage('footer', '');
?>