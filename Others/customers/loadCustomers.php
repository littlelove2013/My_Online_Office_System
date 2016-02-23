<?php
	session_start();
	if(!$_GET[loadCustomers]){
		echo "
			<script language='javascript'>
				alert('参数不正确');
				window.location.href='../../notLogin.html';
			</script>
		";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LoadFunds</title>
<link href="../../CSS/loading.css" rel="stylesheet" type="text/css" />
<meta http-equiv="refresh" content="1;url=dealWithCustomers.php?customer_type=all">
</head>

<body class="loading">
<div class="loading">
	<img src="../../image/loading.gif" />
    <p>LOADING......</p>
</div>
<?php
	header("Content-Type:text/html;charset=utf8");
	$debug=false;
	include("inc/DB/Mode.php");
	
	$loadCustomers=new Mode("personal");
	if ($debug){
		$data=$loadCustomers->select();
		print_r($data);
	}
	/*
	$insertData = array('深圳市腾讯计算机系统有限公司','深圳','518000','0755-83765566','service@QQ.com',' ','深圳市腾讯计算机系统有限公司成立于1998年11月，由马化腾、张志东、许晨晔、陈一丹、曾李青五位创始人共同创立。是中国最大的互联网综合服务提供商之一，也是中国服务用户最多的互联网企业之一。');
	print_r($insertData);
	if($loadFunds->insert($insertData)){
		echo "<p>insert Success!</p>";
	}*/
	//获取个人捐赠人
	$personal_table = "personal";
	$personal_field="
		personal_id as id,
		'个人' as '客户类型',
		personal_name as 'name'";
	$loadCustomers->setOptionsTable($personal_table);
	$loadCustomers->setOptionsField($personal_field);
	$personal_data=$loadCustomers->select();
	if($debug){
		echo "<p>";
		//$personal_data=$loadCustomers->select();
		print_r($personal_data);
		echo "</p>";
	}
	//获取集体捐赠
	$group_table = "group";
	$group_field="
		group_id as id,
		'集体' as '客户类型',
		group_name as 'name' ";;
	$loadCustomers->setOptionsTable($group_table);
	$loadCustomers->setOptionsField($group_field);
	$group_data=$loadCustomers->select();
	if($debug){
		echo "<p>";
		
		print_r($group_data);
		echo "</p>";
	}
	//获取机构捐赠
	$company_table = "company";
	$company_field="
		company_id as id,
		'机构' as '客户类型',
		company_name as 'name'";;
	$loadCustomers->setOptionsTable($company_table);
	$loadCustomers->setOptionsField($company_field);
	$company_data=$loadCustomers->select();
	if($debug){
		echo "<p>";
		
		print_r($company_data);
		echo "</p>";
	}
	
	$_SESSION['personal_customers']=$personal_data;
	$_SESSION['group_customers']=$group_data;
	$_SESSION['company_customers']=$company_data;
	
	//print_r($_SESSION['company_funds']);
	//header('Location: '.'showFunds.php');
	//header("refresh:1;url=dealWithCustomers.php?customer_type=all");
?>
</body>
</html>