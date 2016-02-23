<?php
	session_start();
	if(!$_GET[loadFunds]){
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
	<img src="../image/loading.gif" />
    <p>LOADING......</p>
</div>
<?php
	header("Content-Type:text/html;charset=utf8");
	$debug=false;
	include("inc/DB/Mode.php");
	
	$loadFunds=new Mode("company");
	if ($debug){
		$data=$loadFunds->select();
		print_r($data);
	}
	/*
	$insertData = array('深圳市腾讯计算机系统有限公司','深圳','518000','0755-83765566','service@QQ.com',' ','深圳市腾讯计算机系统有限公司成立于1998年11月，由马化腾、张志东、许晨晔、陈一丹、曾李青五位创始人共同创立。是中国最大的互联网综合服务提供商之一，也是中国服务用户最多的互联网企业之一。');
	print_r($insertData);
	if($loadFunds->insert($insertData)){
		echo "<p>insert Success!</p>";
	}*/
	//获取个人捐赠人
	$personal_table = "donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=0
				   inner join personal on donate_personal_id=personal_id";
	$personal_field="
					donated_funds_id,personal_id as customer_id,project_name as '所属项目',donated_funds_amount as '价值',donate_type_name as '捐赠类型',donate_customer_type as '客户类型',personal_name as '客户',donated_funds_recorder_id as '录入人',donated_funds_lastedit_id as '最后编辑',donated_funds_date as '捐赠时间',donated_funds_lastedit_date as '编辑时间'";
	$loadFunds->setOptionsTable($personal_table);
	$loadFunds->setOptionsField($personal_field);
	$where="";
	if(!empty($_GET[project_id])){
		$where.="project_id=".$_GET[project_id];
	}
	else
		if(!empty($_GET[personal_id])){
			$where.="personal_id=".$_GET[project_id];
		}
	$loadFunds->setOptionsWhere($where);
	$personal_data=$loadFunds->select();
	if($debug){
		echo "<p>";
		$personal_data=$loadFunds->select();
		print_r($personal_data);
		echo "</p>";
	}
	//获取集体捐赠
	$group_table = "donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=1
				   inner join `group` on donate_group_id=group_id";
	$group_field="donated_funds_id,group_id as customer_id,project_name as '所属项目',donated_funds_amount as '价值',donate_type_name as '捐赠类型',donate_customer_type as '客户类型',group_name as '客户',donated_funds_recorder_id as '录入人',donated_funds_lastedit_id as '最后编辑',donated_funds_date as '捐赠时间',donated_funds_lastedit_date as '编辑时间'";
	$loadFunds->setOptionsTable($group_table);
	$loadFunds->setOptionsField($group_field);
	$where="";
	if(!empty($_GET[project_id])){
		$where.="project_id=".$_GET[project_id];
	}
	else
		if(!empty($_GET[group_id])){
			$where.="group_id=".$_GET[project_id];
		}
	$loadFunds->setOptionsWhere($where);
	$group_data=$loadFunds->select();
	if($debug){
		echo "<p>";
		
		print_r($groupl_data);
		echo "</p>";
	}
	//获取机构捐赠
	$company_table = "donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=2
				   inner join company on donate_company_id=company_id";
	$company_field="donated_funds_id,company_id as customer_id,project_name as '所属项目',donated_funds_amount as '价值',donate_type_name as '捐赠类型',donate_customer_type as '客户类型',company_name as '客户',donated_funds_recorder_id as '录入人',donated_funds_lastedit_id as '最后编辑',donated_funds_date as '捐赠时间',donated_funds_lastedit_date as '编辑时间'";
	$loadFunds->setOptionsTable($company_table);
	$loadFunds->setOptionsField($company_field);
	$where="";
	if(!empty($_GET[project_id])){
		$where.="project_id=".$_GET[project_id];
	}
	else
		if(!empty($_GET[personal_id])){
			$where.="company_id=".$_GET[project_id];
		}
	$loadFunds->setOptionsWhere($where);
	$company_data=$loadFunds->select();
	if($debug){
		echo "<p>";
		print_r($company_data);
		echo "</p>";
	}
	//改时间和客户类型以及加上操作
	setTypeToStr($personal_data);
	setTypeToStr($group_data);
	setTypeToStr($company_data);
	
	$_SESSION['personal_funds']=$personal_data;
	$_SESSION['group_funds']=$group_data;
	$_SESSION['company_funds']=$company_data;
	
	//print_r($_SESSION['company_funds']);
	//header('Location: '.'showFunds.php');
	//header("refresh:1;url=dealWithFunds.php?customer_type=all");
	echo "
		<script language='javascript'>
				window.location.href='dealWithFunds.php?customer_type=all';
		</script>
	";
?>
</body>
<?php
	//把客户改成字符串,添加操作
	function setTypeToStr(&$data){
		foreach($data as $keys => $values){
			switch($values['客户类型']){
				case 0:
					$values['客户类型']='个人';
					break;
				case 1:
					$values['客户类型']='集体';
					break;
				case 2:
					$values['客户类型']='机构';
					break;
			}
			$values['操作']="<a href='../Others/customers/oneCustomerShow/more_info/insertUpdateDonate/index.php?customer_type=".$values['客户类型']."&customer_id=".$values[customer_id]."&donated_funds_id=".$values[donated_funds_id]."'>编辑</a>";
			$delete="<br/><a href='../Others/customers/oneCustomerShow/more_info/insertUpdateDonate/deleteP.php?donated_funds_id=".$values[donated_funds_id]."'>删除本次记录(谨慎)</a>	";
			if($_SESSION[is_delete]==true){
				$values['操作'].=$delete;
			}
			unset($values[customer_id]);
			unset($values[donated_funds_id]);
			$data[$keys]=$values;
			//print_r($values);
		}
	}
?>
</html>