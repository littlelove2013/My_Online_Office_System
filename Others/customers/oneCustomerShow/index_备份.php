<?php
	
	header("Content-Type:text/html;charset=utf8");
	if( empty($_GET[customer_type]) || empty($_GET[customer_id]) ){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	include("../../../Tools/showPage.php");
	include("../../../Tools/getMysqlDataFun.php");
	include("../../../Tools/showTable.php");
	$data=array();
	//获取相应类别的数据
	switch($_GET[customer_type]){
	case '个人':
		//获取个人的值
			$table="personal";
			$field="
				'个人' as '客户类型',
		personal_name as 'name',
		personal_sex as '性别',
		personal_date as '生日',
		personal_nation as '民族',
		personal_origin as '籍贯',
		personal_country as '国家',
		personal_province as '省市',
		personal_city as '城市',
		personal_address as '详细地址',
		personal_phone_num as '联系电话',
		personal_email as '个人邮箱',
		personal_fax as '传真',
		personal_zipcode as '邮编',
		personal_remarks as '备注'
			";
			$data=getTable($table,$field,$_GET[customer_id]);
			$data=current($data);
			if($data[生日]!=''){
				$data[生日]=date("Y-m-d",$data[生日]);
			}
			if($data[性别]==0){
				$data[性别]='男';
			}else
				if($data[性别]==1){
					$data[性别]='女';
				}else{
					$data[性别]='性别不详';
				}
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
		//我的捐赠记录
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
		$where="personal_id=".$_GET[customer_id];
		$myDonatedRecorder=getTableM($table,$field,$where);
		setTimeToStr($myDonatedRecorder,'捐赠时间');
		$myDonatedRecorderShow=new showPage($myDonatedRecorder,"index.php");
		$myDonatedRecorderShow->setPagePrefix("myDonatedRecorder_");
		echo "<p>";
		$myDonatedRecorderShow->Display("我的捐赠记录");
		
		//获取个人所管理的集体
		$table="personal inner join manage_group on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id";
		$field="group_id as id,group_name as '我管理的集体'";
		$where="personal_id=".$_GET[customer_id];
		$myManageGroup=getTableM($table,$field,$where);
		
		//我管理的集体的捐赠记录
		//只有不为空时才产生
		if(!empty($myManageGroup)){
			$myManageGroupShow=new showPage($myManageGroup,"index.php");
			$myManageGroupShow->setPagePrefix("myManageGroup_");
			echo "<p>";
			$myManageGroupShow->Display("我管理的集体");
			
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
			$myManageGroupDonatedRecorderShow=new showPage($myManageGroupDonatedRecorder,"index.php");
			$myManageGroupDonatedRecorderShow->setPagePrefix("myManageGroupDonatedRecorder_");
			echo "<p>";
			$myManageGroupDonatedRecorderShow->Display("我管理的集体的捐赠记录");
		}
		//我所属的集体
		$table="personal inner join group_have on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id";
		$field="group_id as id,group_name as '我的集体'";
		$where="personal_id=".$_GET[customer_id];
		$myGroup=getTableM($table,$field,$where);
		
		//如果非空，则查找我集体的捐赠记录
		if(!empty($myGroup)){
			//显示我的所属公司
			$myGroupShow=new showPage($myGroup,"index.php");
			$myGroupShow->setPagePrefix("myGroup_");
			echo "<p>";
			$myGroupShow->Display("我所属的集体");
			
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
			setTimeToStr($myGroupDonatedRecorder,'捐赠时间');
			//print_r($myGroupDonatedRecorder);
			$myGroupDonatedRecorderShow=new showPage($myGroupDonatedRecorder,"index.php");
			$myGroupDonatedRecorderShow->setPagePrefix("myGroupDonatedRecorder_");
			echo "<p>";
			$myGroupDonatedRecorderShow->Display("我所属的集体的捐赠记录");
			
		}
		
		//查找我管理的公司
		$table="personal inner join manage_company on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id";
		$field="company_id as id,company_name as '机构名称'";
		$where="personal_id=".$_GET[customer_id];
		$myManageCompany=getTableM($table,$field,$where);
		//非空则找我管理的公司的捐赠记录
		if(!empty($myManageCompany)){
			//显示我的管理公司
			$myManageCompanyShow=new showPage($myManageCompany,"index.php");
			$myManageCompanyShow->setPagePrefix("myManageCompany_");
			echo "<p>";
			$myManageCompanyShow->Display("我管理的公司");
			
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
			$myManageCompanyDonatedRecorderShow=new showPage($myManageCompanyDonatedRecorder,"index.php");
			$myManageCompanyDonatedRecorderShow->setPagePrefix("myManageCompanyDonatedRecorder_");
			$myManageCompanyDonatedRecorderShow->Display("我管理的公司的捐赠记录");
		}
		//查找我所属的公司
		$table="
			personal inner join company_have on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id
		";
		$field="
			personal_id as id,company_name as '机构名称'
		";
		$where="personal_id=".$_GET[customer_id];
		$myCompany=getTableM($table,$field,$where);
		//如果不为空则展示我所属公司的捐赠记录
		if(!empty($myCompany)){
			//显示我的管理公司
			$myCompanyShow=new showPage($myCompany,"index.php");
			$myCompanyShow->setPagePrefix("myCompany_");
			echo "<p>";
			$myCompanyShow->Display("我所属的公司");
			
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
			$myCompanyDonatedRecorderShow=new showPage($myCompanyDonatedRecorder,"index.php");
			$myCompanyDonatedRecorderShow->setPagePrefix("myManageCompanyDonatedRecorder_");
			$myCompanyDonatedRecorderShow->Display("我管理的公司的捐赠记录");
		}
			//print_r($data);
			break;
	case '集体':
		//获取集体的值
		$table="group";
		$field="
			'集体' as '客户类型',
		group_name as 'name',
		group_remarks as '备注'
		";
		$data=getTable($table,$field,$_GET[customer_id]);
		$data=current($data);
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
		//print_r($data);
			break;
	case '机构':
		//获取机构的值
		$table="company";
		$field="
			'机构' as '客户类型',
		company_name as 'name',
		company_address as '地址',
		company_zipcode as '邮编',
		company_phone_num as '联系电话',
		company_email as '机构邮箱',
		company_fax as '传真',
		company_remarks as '备注'
		";
		$data=getTable($table,$field,$_GET[customer_id]);
		$data=current($data);
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
		//print_r($data);
			break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title></title>
</head>

<body>
<?php
	//include("../../../Tools/showTable.php");
	//$customerData=new showTable($data);
	//$customerData->Display($data[name].$_GET[customer_type].'信息');
?>
</body>
</html>