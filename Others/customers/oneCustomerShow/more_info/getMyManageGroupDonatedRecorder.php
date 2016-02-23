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
	//获取个人所管理的集体
		$table="personal inner join manage_group on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id";
		$field="group_id as id,group_name as '我管理的集体'";
		$where="personal_id=".$_GET[customer_id];
		$myManageGroup=getTableM($table,$field,$where);
		
		//我管理的集体的捐赠记录
		//只有不为空时才产生
		if(!empty($myManageGroup)){
			foreach($myManageGroup as $keys=>$values){
				$values['我管理的集体']="<a id='table_td' href='../index.php?customer_type=集体&customer_id=".$values[id]."' target='_top'>".$values['我管理的集体']."</a>";
				$values['操作']="
								<a id='table_td' href='insertUpdateManage/deleteP.php?customer_type=集体&manage=manage&personal_id=".$_GET[customer_id]."&id=".$values[id]."'>放弃管理</a>
								";
				$myManageGroup[$keys]=$values;
			}
			$myManageGroupShow=new showPage($myManageGroup,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$insert="(<a href='insertUpdateManage?customer_type=集体&manage=manage&personal_id=".$_GET[customer_id]."'>添加管理集体</a>)";
			$myManageGroupShow->Display("我管理的集体".$insert);
			
			$table="
				donated_funds inner join project on donated_funds_project_id=project_id
					   inner join donate_type on donated_funds_donatetype_id=donate_type_id
					   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=1
					   inner join `group` on donate_group_id=group_id
			";
			$field="
				project_name as '所属项目',
			donated_funds_amount as '价值',
			donate_type_name as '捐赠类型',
			group_name as '捐赠集体',
			donated_funds_recorder_id as '录入人',
			donated_funds_lastedit_id as '最后编辑',
			donated_funds_date as '捐赠时间'
			";
			$str='';
			foreach($myManageGroup as $keys=>$values){
				$str.="group_id=".$values[id]." or ";
			}
			//echo "str:".$str."<p>";
			$where=substr($str,0,-4);
			//echo "where:".$where."<p>";
			$myManageGroupDonatedRecorder=getTableM($table,$field,$where);
			setTimeToStr($myManageGroupDonatedRecorder,'捐赠时间');
			$myManageGroupDonatedRecorderShow=new showPage($myManageGroupDonatedRecorder,$current_file);
			$myManageGroupDonatedRecorderShow->setPagePrefix("myManageGroupDonatedRecorder_");
			echo "<p>";
			$myManageGroupDonatedRecorderShow->Display("我管理的集体的捐赠记录");
		}else{
			$data[]=array("还没有ta管理的集体"=>"<a id='table_td' href='insertUpdateManage?customer_type=集体&manage=manage&personal_id=".$_GET[customer_id]."'>现在去管理一个集体？</a>");
			$myManageGroupShow=new showPage($data,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("还没有管理的集体");
		}
?>
</body>
</html>