<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>install_sql</title>
</head>

<body>
<?php
	include("../Tools/getMysqlDataFun.php");
	//install_sql("../Tools/install.sql");
	$install_sql=file_get_contents("../Tools/sql/install.sql");
	echo $install_sql;
?>
</body>
</html>