<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
	//$_SESSION[USER_ID]="徐志江";
	if(empty($_SESSION[USER_ID])){
		if(empty($_SESSION[LOGIN_USER_ID])){
			$USER_ID='未知';
		}else{
			$USER_ID=$_SESSION[LOGIN_USER_ID];
			//将GB2312转换成UTF-8字符串
			$USER_ID=iconv('GB2312','UTF-8',$USER_ID);
		}
		$_SESSION[USER_ID]=$USER_ID;
	}
	echo "USER_ID:".$_SESSION[USER_ID]."<p>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>

<body>

<form name="insertUpdateDonated" method="post" action="deal.php">
<?php
	if(empty($_GET[customer_type])){
		//必须传入用户类型
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../../../notLogin.html';
			</script>
		";
	}
	//echo '欢迎添加纪录<p>';
	include("../../../../../Tools/showPage.php");
	include("../../../../../Tools/getMysqlDataFun.php");
	include("../../../../../Tools/showTable.php");
	//这里开始建表
	$customer_data=array();//$data用于存储查找到的用户列表
	$select='';
	//已知用户类型
	switch($_GET[customer_type]){
		case '个人':
				//echo "personal<p>";
				//获取个人列表
				$customer_data=getTable('personal','personal_id as id,personal_name as name');
				//设置隐藏域
				echo "<input type=\"hidden\" name='insertDonate[donate_group_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_company_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_customer_type]' value='0'/>";
				$select="<select id='selectCustomer' name='insertDonate[donate_personal_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value='". $values[id] ."'>".$values[name]."</option>";
				}
				$select.="</select>";
				//print_r($data);
						break;
		case '集体':
				//获取集体列表
				$customer_data=getTable('group','group_id as id,group_name as name');
				//设置隐藏域
				echo "<input type=\"hidden\" name='insertDonate[donate_personal_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_company_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_customer_type]' value='1'/>";
				$select="<select id='selectCustomer' name='insertDonate[donate_group_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value='". $values[id] ."'>".$values[name]."</option>";
				}
				$select.="</select>";
						break;
		case '机构':
				//获取机构列表
				$customer_data=getTable('company','company_id as id,company_name as name');
				//设置隐藏域
				echo "<input type=\"hidden\" name='insertDonate[donate_personal_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_group_id]' value=''/>";
				echo "<input type=\"hidden\" name='insertDonate[donate_customer_type]' value='2'/>";
				$select="<select id='selectCustomer' name='insertDonate[donate_company_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value='". $values[id] ."'>".$values[name]."</option>";
				}
				$select.="</select>";
						break;
	}
	//print_r($customer_data);
	
	//设置显示数据data
	$data=array("客户类型"=>$_GET[customer_type],'选择客户'=>$select);
	//获取项目选项
	$projectData=getTable('project',"project_id as id,project_name as name");
//	echo "project:";
//	print_r($projectData);
	$selectPro="<select id='selectProject' name='insertDonatedFunds[donated_funds_project_id]'>";
	foreach($projectData as $keys=>$values){
		$selectPro.="<option value=\"".$values[id]."\"> " .$values[name]. " </option>";
	}
	$selectPro.="</select>";
	$data['选择项目']=$selectPro;
	//获取捐赠类别选项
	$donateTypeData=getTable('donate_type',"donate_type_id as id,donate_type_name as name");
//	echo "donateType:";print_r($donateTypeData);
	$selectDonateType="<select id='selectDonateType' name='insertDonatedFunds[donated_funds_donatetype_id]'>";
	foreach($donateTypeData as $keys=>$values){
		$selectDonateType.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	$selectDonateType.="</select>";
	$data['选择捐赠类型']=$selectDonateType;
	//币种
	$selectCurrency="<select id='selectCurrency' name='insertDonatedFunds[donated_funds_currency]'>
							<option value='人民币'>人民币</option>
					</select>";
	$data['选择币种']=$selectCurrency;
	
	if(!empty($_GET[donated_funds_id])){
		//则说明是对一次已存在的资金进行修改
		//设置隐藏域
		echo "<input type=\"hidden\" name='donate_donated_funds_id' value='".$_GET[donated_funds_id]."'/>";
		//先获取本次资金的信息
		$myDonatedFunds=getTable("donated_funds",'',$_GET[donated_funds_id]);
		$myDonatedFunds=current($myDonatedFunds);
		//捐赠日期
		$data['捐赠日期']="<input type='date' name='insertDonatedFunds[donated_funds_date]' value=\"".date("Y-m-d",$myDonatedFunds[donated_funds_date])."\" >";
		$data['价值']="<input type=text name='insertDonatedFunds[donated_funds_amount]' value='".$myDonatedFunds['donated_funds_amount']."'/>";
		//备注
		$data['备注']="<textarea name='insertDonatedFunds[donated_funds_remarks]'>".$myDonatedFunds['donated_funds_remarks']."</textarea>";
		
		//隐藏域
		echo "<input type=\"hidden\" id='selectedProjectId' value='".$myDonatedFunds[donated_funds_project_id]."'/>";
		echo "<input type=\"hidden\" id='selectedDonateTypeId' value='".$myDonatedFunds[donated_funds_donatetype_id]."'/>";
		echo "<input type=\"hidden\" id='selectedCurrency' value='".$myDonatedFunds[donated_funds_currency]."'/>";
		//更新日期
		echo "<input type=\"hidden\" name='insertDonatedFunds[donated_funds_date]' value='".time()."'/>";
		//只需要改最后编辑人
		echo "<input type=\"hidden\" name='insertDonatedFunds[donated_funds_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		
		
		//显示内容
		$change=new showTable($data);
		$change->Display("更改已捐献资金记录");
		
		echo "<input type='submit' name='update' value='修改'/>";
		
	}else{
		//这是添加一笔资金
		$data['捐赠日期']="<input type='date' name='insertDonatedFunds[donated_funds_date]' value=\"".date("Y-m-d",time())."\">";
		$data['价值']="<input type=text name='insertDonatedFunds[donated_funds_amount]' value='".$myDonatedFunds['donated_funds_amount']."' />";
		//备注
		$data['备注']="<textarea name='insertDonatedFunds[donated_funds_remarks]'></textarea>";
		//更新日期
		echo "<input type=\"hidden\" name='insertDonatedFunds[donated_funds_date]' value='".time()."'/>";
		
		//隐藏域
		echo "<input type=\"hidden\" id='selectedProjectId' value='1'/>";
		echo "<input type=\"hidden\" id='selectedDonateTypeId' value='1'/>";
		echo "<input type=\"hidden\" id='selectedCurrency' value=''/>";
		
		//第一次最后编辑人和记录人是同一人
		echo "<input type=\"hidden\" name='insertDonatedFunds[donated_funds_recorder_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type=\"hidden\" name='insertDonatedFunds[donated_funds_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		$add=new showTable($data);
		$add->Display("添加捐赠记录");
		
		echo "<input type='submit' name='insert' value='添加'/>";
	}
	//设置隐藏值来设置select的值
	//echo $_GET[customer_id]."<p>";
	echo "<input type=\"hidden\" id='customer_value' value='".$_GET[customer_id]."' />";
?>

</form>
</body>
<script language="javascript">
	//用于设置初始
	var customer_value=document.getElementById('customer_value').value;
	if(customer_value!=''){
		document.getElementById('selectCustomer').value=customer_value;
	}
	//document.write("hello world:"+customer_value+"\n");
	var selectedProjectId=document.getElementById('selectedProjectId').value;
	if(selectedProjectId!=''){
		document.getElementById('selectProject').value=selectedProjectId;
	}
	//document.write("hello world:"+selectedProjectId+"\n");	
	var selectedDonateTypeId=document.getElementById('selectedDonateTypeId').value;
	if(selectedDonateTypeId!=''){
		document.getElementById('selectDonateType').value=selectedDonateTypeId;
	}
	//document.write("selectedDonateTypeId:"+selectedDonateTypeId+"\n");	
	var selectedCurrency=document.getElementById('selectedCurrency').value;
	if(selectedCurrency!=''){
		document.getElementById('selectCurrency').value=selectedCurrency;
	}
	//document.write("hello world:"+selectedCurrency+"\n");	
	//document.getElementById('selectCustomer').value=customer_value;
	//document.write("document.getElementById('selectCustomer').value:"+document.getElementById('selectCustomer').value+"\t\n");	
	//document.getElementById('selectProject').value=selectedProjectId;
	//document.write("document.getElementById('selectProject').value:"+document.getElementById('selectProject').value+"\t\n");	
	//document.getElementById('selectDonateType').value=selectedDonateTypeId;
	//document.write("document.getElementById('selectDonateType').value:"+document.getElementById('selectDonateType').value+"\t\n");
	//document.getElementById('selectCurrency').value=selectedCurrency;
	//document.write("document.getElementById('selectCurrency').value:"+document.getElementById('selectCurrency').value+"\t\n");
	
</script>
</html>