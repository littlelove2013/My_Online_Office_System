<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../Tools/CSS/chooseType.css" rel="stylesheet" type="text/css" />
<title>选择客户类型</title>
</head>

<body>
<div>
	<a href="index.php" target="_top">
    	<img width="50" height="30" src="../image/submit.png" />
    </a>
</div>
<div style=" width:100%; margin-top:30px;">
	<a id="choose" href="../Others/customers/oneCustomerShow/more_info/insertUpdateDonate/index.php?customer_type=个人" target="addDonatedFunds">个人客户</a>
    <a id="choose" href="../Others/customers/oneCustomerShow/more_info/insertUpdateDonate/index.php?customer_type=集体" target="addDonatedFunds">集体客户</a>
    <a id="choose" href="../Others/customers/oneCustomerShow/more_info/insertUpdateDonate/index.php?customer_type=机构" target="addDonatedFunds">机构客户</a>
</div>
<div align="center">
	<iframe width="100%" height="500px" src="../Others/noItemSelect.html" name="addDonatedFunds">
    </iframe>
</div>
</body>
</html>