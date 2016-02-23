<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
//获取值，然后显示出来
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showTable.php");
	if(empty($_GET[intercourse_id])){
		echo "<script language='javascript'>
				alert('错误访问本页面');
				history.go(-1);
			</script>";
	}
	$intercourse_id=$_GET[intercourse_id];
	//获得该记录的信息，显示出来
	$field="
			intercourse_id as id,
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'
	";
	$myIntercourse=getTable("intercourse",$field,$_GET[intercourse_id]);
	$myIntercourse=current($myIntercourse);
	//改日期
	$myIntercourse['日期']=date("Y-m-d H:i:s",$myIntercourse['日期']);
	//echo "<p>";
	//print_r($myIntercourse);
	//获取参加该交往的客户
	//个人用户
	$field="personal_name as '客户'";
	$table="intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join `personal` on personal_personal_id=personal_id";
	$where="intercourse_id=".$intercourse_id;
	$personal_info=getTableM($table,$field,$where);
	$personal="";
	foreach($personal_info as $keys=>$values){
		$personal.=$values['客户']."<br/>";
	}
	//echo "<br/>personal：".$personal."";
	$myIntercourse['参加个人客户']=$personal;
	//集体用户
	$field="group_name as '客户'";
	$table="intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join `group` on group_group_id=group_id";
	$where="intercourse_id=".$intercourse_id;
	$group_info=getTableM($table,$field,$where);
	$group="";
	foreach($group_info as $keys=>$values){
		$group.=$values['客户']."<br/>";
	}
	//echo "<br/>".$group."";
	$myIntercourse['参加集体客户']=$group;
	//公司用户
	$field="company_name as '客户'";
	$table="intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join `company` on company_company_id=company_id";
	$where="intercourse_id=".$intercourse_id;
	$company_info=getTableM($table,$field,$where);
	$company="";
	foreach($company_info as $keys=>$values){
		$company.=$values['客户']."<br/>";
	}
	//echo "<br/>".$company."";
	$myIntercourse['参加公司客户']=$company;
	
	$showTable=new showTable($myIntercourse);
	$update="(<a href='../insertUpdate/index.php?intercourse_id=".$myIntercourse[id]."'>编辑</a>)";
	$showTable->Display("交往记录".$update);
	
?>
</body>
</html>