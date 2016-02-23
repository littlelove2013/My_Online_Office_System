<?php
	session_start();
	$_SESSION[is_delete]=true;
	if(!$_GET[loadInters]){
		echo "
			<script language='javascript'>
				alert('参数不正确');
				window.location.href='../notLogin.html';
			</script>
		";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LoadFunds</title>
<link href="../CSS/loading.css" rel="stylesheet" type="text/css" />
</head>

<body class="loading">
<div class="loading">
	<img src="../../image/loading.gif" />
    <p>LOADING......</p>
</div>
<?php
	header("Content-Type:text/html;charset=utf8");
	$debug=false;
	include("DB/Mode.php");
	
	$loadInters=new Mode("intercourse");
	if ($debug){
		$data=$loadInters->select();
		print_r($data);
	}
	/*
	$insertData = array('深圳市腾讯计算机系统有限公司','深圳','518000','0755-83765566','service@QQ.com',' ','深圳市腾讯计算机系统有限公司成立于1998年11月，由马化腾、张志东、许晨晔、陈一丹、曾李青五位创始人共同创立。是中国最大的互联网综合服务提供商之一，也是中国服务用户最多的互联网企业之一。');
	print_r($insertData);
	if($loadFunds->insert($insertData)){
		echo "<p>insert Success!</p>";
	}*/
	//获取个人捐赠人
	$personal_table = "intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join personal on personal_personal_id=personal_id";
	$personal_field="intercourse_id as id,
		'个人' as '客户类型',
		personal_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'";
	$loadInters->setOptionsTable($personal_table);
	$loadInters->setOptionsField($personal_field);
	$where="";
	if($_GET[personal_id]){
		$where="personal_id=".$_GET[personal_id];
	}else{
		if($_GET[intercourse_id]){
			$where="intercourse_id=".$_GET[intercourse_id];
		}
	}
	$loadInters->setOptionsWhere($where);
	$personal_data=$loadInters->select();
	if($debug){
		echo "<p>";
		$personal_data=$loadInters->select();
		print_r($personal_data);
		echo "</p>";
	}
	//获取集体捐赠
	$group_table = "intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 	inner join `group` on group_group_id=group_id";
	$group_field="intercourse_id as id,
		'集体' as '客户类型',
		group_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'";;
	$loadInters->setOptionsTable($group_table);
	$loadInters->setOptionsField($group_field);
	$where="";
	if($_GET[group_id]){
		$where="group_id=".$_GET[group_id];
	}else{
		if($_GET[intercourse_id]){
			$where="intercourse_id=".$_GET[intercourse_id];
		}
	}
	$loadInters->setOptionsWhere($where);
	$group_data=$loadInters->select();
	if($debug){
		echo "group:<p>";
		
		print_r($group_data);
		echo "</p>";
	}
	//获取机构捐赠
	$company_table = "intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join company on company_company_id=company_id";
	$company_field="intercourse_id as id,
		'机构' as '客户类型',
		company_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'";;
	$loadInters->setOptionsTable($company_table);
	$loadInters->setOptionsField($company_field);
	$where="";
	if($_GET[company_id]){
		$where="company_id=".$_GET[company_id];
	}else{
		if($_GET[intercourse_id]){
			$where="intercourse_id=".$_GET[intercourse_id];
		}
	}
	$loadInters->setOptionsWhere($where);
	$company_data=$loadInters->select();
	if($debug){
		echo "company:<p>";
		
		print_r($company_data);
		echo "</p>";
	}
	//为每个数组加上操作菜单
	$data=$personal_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href=''>编辑</a>";
		$delete="<br/><a href=''>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['personal_inters']=$data;
	$data=$group_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href=''>编辑</a>";
		$delete="<br/><a href=''>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['group_inters']=$data;
	$data=$company_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href=''>编辑</a>";
		$delete="<br/><a href=''>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['company_inters']=$data;
	//print_r($_SESSION['company_funds']);
	//header('Location: '.'showFunds.php');
	header("refresh:1;url=dealWithInters.php?customer_type=all");
?>
</body>
</html>