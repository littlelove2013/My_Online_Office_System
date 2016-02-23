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
	$loadInters->setOptionsWhere("company_id=".$_GET[customer_id]);
	$company_data=$loadInters->select();
		if(!empty($company_data)){
			foreach($company_data as $keys=>$values){
				$values['操作']="<a id='table_td' href='../../../../inters/insertUpdate/index.php?intercourse_id=".$values[id]."' target='_top'>编辑</a>";
				$values['活动主题']="<a id='table_td' href='../../../../inters/oneIntersShow/index.php?intercourse_id=".$values[id]."' target='_top'>".$values['活动主题']."</a>";
				$company_data[$keys]=$values;
			}
			setTimeToStr($company_data,'日期');
		}
		$company_data_show=new showPage($company_data,$current_file);
		$company_data_show->setPagePrefix("personal_data_");
		echo "<p>";
		$insert="(<a href='../../../../inters/insertUpdate/index.php' target='_top'>添加交往记录</a>)";
		$company_data_show->Display("交往记录".$insert);
		
?>
</body>
</html>