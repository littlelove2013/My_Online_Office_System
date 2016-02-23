<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>

<body>
<?php
	if(empty($_GET[customer_id]) ){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../../notLogin.html';
			</script>
		";
	}
	include("../../../../Tools/showPage.php");
	include("../../../../Tools/getMysqlDataFun.php");
	include("../../../../Tools/showTable.php");
	$current_file = basename($_SERVER['SCRIPT_NAME']);
	$loadInters=new Mode("join_intercourse");
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
	$loadInters->setOptionsWhere("group_id=".$_GET[customer_id]);
	$group_data=$loadInters->select();
		if(!empty($group_data)){
			foreach($group_data as $keys=>$values){
				$values['操作']="<a id='table_td' href='../../../../inters/insertUpdate/index.php?intercourse_id=".$values[id]."' target='_top'>编辑</a>";
				$values['活动主题']="<a id='table_td' href='../../../../inters/oneIntersShow/index.php?intercourse_id=".$values[id]."' target='_top'>".$values['活动主题']."</a>";
				$group_data[$keys]=$values;
			}
			setTimeToStr($group_data,'日期');
		}
		$group_data_show=new showPage($group_data,$current_file);
		$group_data_show->setPagePrefix("personal_data_");
		echo "<p>";
		$insert="(<a href='../../../../inters/insertUpdate/index.php' target='_top'>添加交往记录</a>)";
		$group_data_show->Display("交往记录".$insert);
		
?>
</body>
</html>