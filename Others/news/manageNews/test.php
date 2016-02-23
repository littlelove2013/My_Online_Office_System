<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
</head>

<body>
<?php
	echo "time:".time()."<br>";
	date_default_timezone_set('Asia/Shanghai');  
	echo "time:".time()."<br>";
	echo "date:".date("Y-m-d H:i:s",time())."<br>";
	echo "localtime():".localtime()."<br>";
	//echo "localtime:".date("Y-m-d H:i:s",localtime())."<br>";
?>
</body>
</html>