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
		//查找我管理的公司
		$table="personal inner join manage_company on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id";
		$field="company_id as id,company_name as '机构名称'";
		$where="personal_id=".$_GET[customer_id];
		$myManageCompany=getTableM($table,$field,$where);
		
		//非空则找我管理的公司的捐赠记录
		if(!empty($myManageCompany)){
			foreach($myManageCompany as $keys=>$values){
				$values['机构名称']="<a id='table_td' href='../index.php?customer_type=机构&customer_id=".$values[id]."' target='_top'>".$values['机构名称']."</a>";
				$values['操作']="
								<a id='table_td' href='insertUpdateManage/deleteP.php?customer_type=机构&manage=manage&personal_id=".$_GET[customer_id]."&id=".$values[id]."'>放弃管理</a>
								";
				$myManageCompany[$keys]=$values;
			}
			//显示我的管理公司
			$myManageCompanyShow=new showPage($myManageCompany,$current_file);
			$myManageCompanyShow->setPagePrefix("myManageCompany_");
			echo "<p>";
			$insert="(<a href='insertUpdateManage?customer_type=机构&manage=manage&personal_id=".$_GET[customer_id]."'>添加管理公司</a>)";
			$myManageCompanyShow->Display("我管理的公司".$insert);
			
			//我管理公司的捐赠记录
			$table="
				donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=2
				   inner join company on donate_company_id=company_id
			";
			$field="
				project_name as '所属项目',
		donated_funds_amount as '价值',
		donate_type_name as '捐赠类型',
		company_name as '捐赠机构',
		donated_funds_recorder_id as '录入人',
		donated_funds_lastedit_id as '最后编辑',
		donated_funds_date as '捐赠时间'
			";
			$str='';
			foreach($myManageCompany as $keys=>$values){
				$str.="company_id=".$values[id]." or ";
			}
			$where=substr($str,0,-4);
			$myManageCompanyDonatedRecorder=getTableM($table,$field,$where);
			setTimeToStr($myManageCompanyDonatedRecorder,'捐赠时间');
			$myManageCompanyDonatedRecorderShow=new showPage($myManageCompanyDonatedRecorder,$current_file);
			$myManageCompanyDonatedRecorderShow->setPagePrefix("myManageCompanyDonatedRecorder_");
			$myManageCompanyDonatedRecorderShow->Display("我管理的公司的捐赠记录");
		}else{
			//为空，则构造时候管理一家公司的字符串
			$data[]=array("还没有ta管理的公司"=>"<a id='table_td' href='insertUpdateManage?customer_type=机构&manage=manage&personal_id=".$_GET[customer_id]."'>现在去管理一个公司？</a>");
			$myManageGroupShow=new showPage($data,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("还没有管理的公司");
		}
?>
</body>
</html>