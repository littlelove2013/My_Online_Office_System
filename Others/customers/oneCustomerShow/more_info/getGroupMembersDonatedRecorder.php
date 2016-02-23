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
	
	//获取个人所管理的集体
		$current_file = basename($_SERVER['SCRIPT_NAME']);
		//echo $current_file."<p>";
		$table="personal inner join group_have on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id";
		$field="personal_id as id,personal_name as '集体成员'";
		$where="group_id=".$_GET[customer_id];
		$myGroup=getTableM($table,$field,$where);
		
		//我管理的集体的捐赠记录
		//只有不为空时才产生
		if(!empty($myGroup)){
			foreach($myGroup as $keys=>$values){
				$values['集体成员']="<a id='table_td' href='../index.php?customer_type=个人&customer_id=".$values[id]."' target='_top'>".$values['集体成员']."</a>";
				$values['操作']="
								<a id='table_td' href='insertUpdateManage/deleteP.php?customer_type=集体&group=group&id=".$_GET[customer_id]."&personal_id=".$values[id]."'>退出本集体</a>
								";
				$myGroup[$keys]=$values;
			}
			$myGroupShow=new showPage($myGroup,$current_file);
			$myGroupShow->setPagePrefix("myGroup_");
			echo "<p>";
			$insert="(<a href='insertUpdateManage?customer_type=个人&group_id=".$_GET[customer_id]."'>添加新成员</a>)";
			$myGroupShow->Display("集体成员".$insert);
			
			$table="
				donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=0
				   inner join personal on donate_personal_id=personal_id
			";
			$field="
					project_name as '所属项目',
					donated_funds_amount as '价值',
					donate_type_name as '捐赠类型',
					personal_name as '捐赠人',
					donated_funds_recorder_id as '录入人',
					donated_funds_lastedit_id as '最后编辑',
					donated_funds_date as '捐赠时间'
			";
			$str='';
			foreach($myGroup as $keys=>$values){
				$str.="personal_id=".$values[id]." or ";
			}
			//echo "str:".$str."<p>";
			$where=substr($str,0,-4);
			//echo "where:".$where."<p>";
			$myGroupDonatedRecorder=getTableM($table,$field,$where);
			setTimeToStr($myGroupDonatedRecorder,'捐赠时间');
			$myGroupDonatedRecorderShow=new showPage($myGroupDonatedRecorder,$current_file);
			$myGroupDonatedRecorderShow->setPagePrefix("myGroupDonatedRecorder_");
			echo "<p>";
			$myGroupDonatedRecorderShow->Display("集体成员的捐赠记录");
		}else{
			//没有时采取的动作
			$data[]=array("还没有成员"=>"<a id='table_td' href='insertUpdateManage/index.php?customer_type=个人&group_id=".$_GET[customer_id]."'>现在去添加一个成员？</a>");
			$myManageGroupShow=new showPage($data,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("还没有成员");
		}
?>
</body>
</html>