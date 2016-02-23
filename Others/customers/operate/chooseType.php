<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>chooseType</title>
<link href="../../../Tools/CSS/chooseType.css" rel="stylesheet" type="text/css" />
</head>

<body>
<a href="../index.php">
<img width="50" height="30" src="../../../image/submit.png" />
</a>
<div style=" width:100%; margin-top:30px;">
	<a id="choose" href="insertUpdate.php?customer_type=个人" target="addCustomer">个人客户</a>
    <a id="choose" href="insertUpdate.php?customer_type=集体" target="addCustomer">集体客户</a>
    <a id="choose" href="insertUpdate.php?customer_type=机构" target="addCustomer">机构客户</a>
</div>
<div align="center">
	<iframe width="100%" height="500px" src="../../noItemSelect.html" name="addCustomer">
    </iframe>
</div>
</body>
</html>
