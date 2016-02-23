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
	//echo "personal_id:".$_GET[customer_id]."<p>";
	include("../../../../Tools/showPage.php");
	include("../../../../Tools/getMysqlDataFun.php");
	include("../../../../Tools/showTable.php");
	$current_file = basename($_SERVER['SCRIPT_NAME']);
	//查找我所属的公司
		$table="
			personal inner join company_have on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id
		";
		$field="
			company_id as id,company_name as '机构名称'
		";
		$where="personal_id=".$_GET[customer_id];
		$myCompany=getTableM($table,$field,$where);
		//如果不为空则展示我所属公司的捐赠记录
		if(!empty($myCompany)){
			foreach($myCompany as $keys=>$values){
				$values['机构名称']="<a id='table_td' href='../index.php?customer_type=机构&customer_id=".$values[id]."' target='_top'>".$values['机构名称']."</a>";
				$values['操作']="
								<a id='table_td' href='insertUpdateManage/deleteP.php?customer_type=机构&personal_id=".$_GET[customer_id]."&id=".$values[id]."'>退出该公司</a>
								";
				$myCompany[$keys]=$values;
			}
			//显示我的管理公司
			$myCompanyShow=new showPage($myCompany,$current_file);
			$myCompanyShow->setPagePrefix("myCompany_");
			echo "<p>";
			$insert="(<a href='insertUpdateManage?customer_type=机构&personal_id=".$_GET[customer_id]."'>加入新公司</a>)";
			$myCompanyShow->Display("我所属的公司".$insert);
			
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
			foreach($myCompany as $keys=>$values){
				$str.="company_id=".$values[id]." or ";
			}
			$where=substr($str,0,-4);
			$myCompanyDonatedRecorder=getTableM($table,$field,$where);
			setTimeToStr($myCompanyDonatedRecorder,'捐赠时间');
			$myCompanyDonatedRecorderShow=new showPage($myCompanyDonatedRecorder,$current_file);
			$myCompanyDonatedRecorderShow->setPagePrefix("myManageCompanyDonatedRecorder_");
			$myCompanyDonatedRecorderShow->Display("我所属的公司的捐赠记录");
		}else{
			//为空，则构造时候加入一家公司的字符串
			$data[]=array("还没有ta所属的公司"=>"<a id='table_td' href='insertUpdateManage?customer_type=机构&personal_id=".$_GET[customer_id]."'>现在去加入一个公司？</a>");
			$myManageGroupShow=new showPage($data,$current_file);
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("还没有加入公司");
		}
?>
</body>
</html>