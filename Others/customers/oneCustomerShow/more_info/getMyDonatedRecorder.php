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
	$table="
				donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=0
				   inner join personal on donate_personal_id=personal_id
		";
		$field="
					donated_funds_id as id,
					project_name as '所属项目',
					donated_funds_amount as '价值',
					donated_funds_currency as '币种',
					donate_type_name as '捐赠类型',
					personal_id,
					personal_name as '捐赠人',
					donated_funds_recorder_id as '录入人',
					donated_funds_lastedit_id as '最后编辑',
					donated_funds_date as '捐赠时间'
	";
		$where="personal_id=".$_GET[customer_id];
		$myDonatedRecorder=getTableM($table,$field,$where);
		if(!empty($myDonatedRecorder)){
			foreach($myDonatedRecorder as $keys=>$values){
				$values['操作']="<a id='table_td' href='insertUpdateDonate/index.php?customer_type=个人&donated_funds_id=".$values[id]."&customer_id=".$values[personal_id]."'>编辑</a>";
				unset($values[id]);
				unset($values[personal_id]);
				$myDonatedRecorder[$keys]=$values;
			}
			setTimeToStr($myDonatedRecorder,'捐赠时间');
		}
		$myDonatedRecorderShow=new showPage($myDonatedRecorder,$current_file);
		$myDonatedRecorderShow->setPagePrefix("myDonatedRecorder_");
		echo "<p>";
		$insert="(<a href='insertUpdateDonate/index.php?customer_type=个人&customer_id=".$_GET[customer_id]."'>添加记录</a>)";
		$myDonatedRecorderShow->Display("我的捐赠记录".$insert);
		
?>
</body>
</html>