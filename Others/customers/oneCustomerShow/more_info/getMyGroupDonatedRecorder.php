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
	//我所属的集体
		$table="personal inner join group_have on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id";
		$field="group_id as id,group_name as '我的集体'";
		$where="personal_id=".$_GET[customer_id];
		$myGroup=getTableM($table,$field,$where);
		
		//如果非空，则查找我集体的捐赠记录
		if(!empty($myGroup)){
			foreach($myGroup as $keys=>$values){
				$values['我的集体']="<a id='table_td' href='../index.php?customer_type=集体&customer_id=".$values[id]."' target='_top'>".$values['我的集体']."</a>";
				$values['操作']="
								<a id='table_td' href='insertUpdateManage/deleteP.php?customer_type=集体&personal_id=".$_GET[customer_id]."&id=".$values[id]."'>退出该集体</a>
								";
				$myGroup[$keys]=$values;
			}
			//显示我的所属公司
			$myGroupShow=new showPage($myGroup,$current_file);
			$myGroupShow->setPagePrefix("myGroup_");
			echo "<p>";
			$insert="(<a href='insertUpdateManage?customer_type=集体&personal_id=".$_GET[customer_id]."'>加入新的集体</a>)";
			$myGroupShow->Display("我所属的集体".$insert);
			
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
			foreach($myGroup as $keys=>$values){
				$str.="group_id=".$values[id]." or ";
			}
			//echo "str:".$str."<p>";
			$where=substr($str,0,-4);
			//$where='';
			//echo "where:".$where."<p>";
			$myGroupDonatedRecorder=getTableM($table,$field,$where);
			//获取我的集体的捐赠记录
			//对每一个集体做超链接
			setTimeToStr($myGroupDonatedRecorder,'捐赠时间');
			//print_r($myGroupDonatedRecorder);
			$myGroupDonatedRecorderShow=new showPage($myGroupDonatedRecorder,$current_file);
			$myGroupDonatedRecorderShow->setPagePrefix("myGroupDonatedRecorder_");
			echo "<p>";
			$myGroupDonatedRecorderShow->Display("我所属的集体的捐赠记录");
			
		}else{
			//没有时采取的动作
			$data[]=array("还没有加入的集体"=>"<a id='table_td' href='insertUpdateManage/index.php?customer_type=集体&personal_id=".$_GET[customer_id]."'>现在去加入一个集体？</a>");
			$myManageGroupShow=new showPage($data,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("还没有加入的集体");

		}
?>
</body>
</html>