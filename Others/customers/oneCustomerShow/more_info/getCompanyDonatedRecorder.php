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
	if( empty($_GET[customer_id]) ){
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
	//	echo $current_file."<p>";
	$table="
				donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=2
				   inner join company on donate_company_id=company_id
		";
		$field="
					donated_funds_id,
					project_name as '所属项目',
		donated_funds_amount as '价值',
		donate_type_name as '捐赠类型',
		company_id,
		company_name as '捐赠机构',
		donated_funds_recorder_id as '录入人',
		donated_funds_lastedit_id as '最后编辑',
		donated_funds_date as '捐赠时间'
	";
		$where="company_id=".$_GET[customer_id];
		
		$companyDonatedRecorder=getTableM($table,$field,$where);
		if(!empty($companyDonatedRecorder)){
			foreach($companyDonatedRecorder as $keys=>$values){
				$values['操作']="<a id='table_td' href='insertUpdateDonate/index.php?customer_type=机构&donated_funds_id=".$values[donated_funds_id]."&customer_id=".$values[company_id]."'>编辑</a>";
				unset($values[donated_funds_id]);
				unset($values[company_id]);
				$myDonatedRecorder[$keys]=$values;
			}
			setTimeToStr($myDonatedRecorder,'捐赠时间');
		}
		setTimeToStr($companyDonatedRecorder,'捐赠时间');
		$companyDonatedRecorderShow=new showPage($companyDonatedRecorder,$current_file);
		$companyDonatedRecorderShow->setPagePrefix("companyDonatedRecorder_");
		echo "<p>";
		//注：此处为何没有写customer_id=4values[company_id]:因为此处是添加记录
		$insert="(<a href='insertUpdateDonate/index.php?customer_type=机构&customer_id=".$_GET[customer_id]."'>添加记录</a>)";
		$companyDonatedRecorderShow->Display("机构捐赠记录".$insert);
?>
</body>
</html>