<?php
	session_start();
	$_SESSION[is_delete]=true;
	if(!$_GET[loadProject]){
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
<title>loadProject</title>
<link href="../CSS/loading.css" rel="stylesheet" type="text/css" />
<meta http-equiv="refresh" content="1;url=dealWithProject.php">
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
	$loadFunds=new Mode("project");
	if ($debug){
		$data=$loadFunds->select();
		print_r($data);
	}
	$field="
	project_id as id,
		project_name as '项目名称',
		project_recorder_id as '记录人',
		project_lastedit_id as '最后编辑',
		pro_manage_dept_name as '管理部门',
		fundrise_person_name as '筹款专员',
		project_type_name as '项目类型',
		project_state_name as '项目状态',
		project_level_name as '项目级别',
		totle_donated as '总捐赠',
		totle_spend as '总支出',
		totle_donated-totle_spend as '剩余',
		project_date as '立项日期',
		project_lastedit_date as '编辑日期'";
	$table="
		project inner join pro_manage_dept on project_manage_id=pro_manage_dept_id
			 inner join fundrise_person on project_fundrise_id=fundrise_person_id
			 inner join project_type on project_type.project_type_id=project.project_type_id
			 inner join project_state on project_state.project_state_id=project.project_state_id
			 inner join project_level on project_level.project_level_id=project.project_level_id
			 inner join (select project_id as all_donated_id,
								case when sum(donated_funds_amount) is null then 0 else sum(donated_funds_amount) end
								as totle_donated
						 from project left outer join donated_funds on project_id=donated_funds_project_id
						 -- where project.project_id=donated_funds_project_id
						 group by project_id) all_donated on all_donated_id=project.project_id
			 inner join (select project_id as all_spend_id,
								case when sum(spend_funds_amount) is null then 0 else sum(spend_funds_amount) end
								as totle_spend
						 from project left outer join spend_funds on project_id=spend_funds_project_id
						 group by project_id) all_spend on all_spend_id=project.project_id
";
	$loadFunds->setOptionsTable($table);
	$loadFunds->setOptionsField($field);
	$data=$loadFunds->select();
	if($debug){
		echo "<p>";
		print_r($data);
		echo "</p>";
	}
	//给每一列添上操作菜单
	foreach($data as $keys=>$values){
		$values["项目名称"]="<a id='table_td' href=\"oneProjectShow/index.php?project_id=".$values[id]."\">".$values["项目名称"]."</a>";
		$values["操作"]="<a href=\"insertUpdate/index.php?project_id=".$values[id]."\">编辑</a>";
		$delete="<br/><a href=\"insertUpdate/deleteP.php?project_id=".$values[id]."\">删除本项目(谨慎)</a>";
		if($_SESSION[is_delete]){
			$values["操作"].=$delete;
		}
		$data[$keys]=$values;
	}
	//print_r($data);
	$_SESSION['project']=$data;
	//header("refresh:1;url=dealWithProject.php");
?>
</body>
</html>