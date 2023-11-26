<?php
DEFINE("CHECK_ACCOUNT", "SELECT account
FROM user_account
WHERE account = '%s' ");

DEFINE("CHECK_EMAIL", "SELECT email
FROM ssn
WHERE email = '%s' ");

DEFINE("SELECT_COUNT_ACCOUNT", "SELECT count(*)
FROM user_account");

DEFINE("SELECT_USER_PASS", "SELECT account, password
FROM user_auth
WHERE account = '%s' ");

DEFINE("SELECT_USER_FULLINFO", "SELECT user_auth.account, user_auth.password, user_auth.quiz1, user_auth.quiz2, user_auth.answer1, user_auth.answer2, ssn.ssn, ssn.email
FROM user_auth
LEFT JOIN ssn ON user_auth.account = ssn.name
WHERE user_auth.account = '%s' ");

DEFINE("INSERT_SSN", "INSERT INTO [ssn](ssn,name,email,job,phone,zip,addr_main,addr_etc,account_num)
VALUES ('%s','%s','%s',0,'telphone','123456','','',1)");

DEFINE("INSERT_USERACCOUNT", "INSERT INTO user_account (account,pay_stat)
VALUES ('%s', 1)");

DEFINE("INSERT_USERAUTH", "INSERT INTO user_auth (account,password,quiz1,quiz2,answer1,answer2)
VALUES ('%s',%s,'%s','%s',%s,%s)");

DEFINE("INSERT_USERINFO", "INSERT INTO user_info (account,ssn,kind)
VALUES ('%s','%s', 99)");

DEFINE("UPDATE_PASSWORD","UPDATE user_auth
SET password = %s
WHERE account = '%s' ");
?>