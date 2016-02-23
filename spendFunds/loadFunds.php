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
	$loadFunds=new Mode("spend_funds");
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
	$field="
	spend_funds_id as id,
	project_name as '项目名称',
spend_funds_amount as '金额',
purpose_name as '资金用途',
spend_funds_recorder_id as '记录人',
spend_funds_lastedit_id as '最后编辑',
approved_dept.pro_manage_dept_name as '执行部门',
approved_name as '批准人',
benefit_dept.pro_manage_dept_name as '受益部门',
fundrise_person_name as '经办人',
spend_funds_date as '支出日期',
spend_funds_lastedit_date as '编辑日期'";
	$table="
		spend_funds inner join project on spend_funds_project_id=project_id
				 inner join purpose on spend_funds_purpose_id=purpose_id
				 inner join pro_manage_dept approved_dept on approved_dept.pro_manage_dept_id=spend_funds_aproved_dept_id
				 inner join approved on spend_funds_approved_id=approved_id
				 inner join pro_manage_dept benefit_dept on benefit_dept.pro_manage_dept_id=spend_funds_benefit_dept_id
				 inner join fundrise_person on spend_funds_manage_id=fundrise_person_id
	";
	$loadFunds->setOptionsTable($table);
	$loadFunds->setOptionsField($field);
	if(!empty($_GET[project_id])){
		$loadFunds->setOptionsWhere("project_id=".$_GET[project_id]);
	}
	$data=$loadFunds->select();
	if($debug){
		echo "<p>";
		
		print_r($data);
		echo "</p>";
	}
	//对$data添加操作
	foreach($data as $keys=>$values){
		$values['操作']="<a href='insertUpdate/index.php?spend_funds_id=".$values[id]."'>编辑</a>";
		$delete="<br/><a href='insertUpdate/deleteP.php?spend_funds_id=".$values[id]."'>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['spendloadfunds']=$data;
	//$_SESSION['group_funds']=$group_data;
	//$_SESSION['company_funds']=$company_data;
	
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
</html>