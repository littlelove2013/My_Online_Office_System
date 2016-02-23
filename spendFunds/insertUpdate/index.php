<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
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
<title>插入更新</title>
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="insertupdate_spend_funds" method="post" action="deal.php">
<?php
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showTable.php");
	$debug=false;
	$data=array();
	
	
	//获取所有purpose
	$table="purpose";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($purpose);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['资金用途']="<select id='select_purpose' name='spend_funds[spend_funds_purpose_id]'>".$$options."</select>";
	//获取所有项目
	$table="project";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($project);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['项目']="<select id='select_project' name='spend_funds[spend_funds_project_id]'>".$$options."</select>";
	//获取所有部门
	$table="pro_manage_dept";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($pro_manage_dept);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['执行部门']="<select id='select_approved_dept' name='spend_funds[spend_funds_aproved_dept_id]'>".$$options."</select>";
	$data['受益部门']="<select id='select_benefit_dept' name='spend_funds[spend_funds_benefit_dept_id]'>".$$options."</select>";
	//获取所有经办人
	$table="fundrise_person";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($fundrise_person);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['经办人']="<select id='select_manage' name='spend_funds[spend_funds_manage_id]'>".$$options."</select>";
	//获取所有的批准人
	$table="approved";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($approved);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['批准人']="<select id='select_approved' name='spend_funds[spend_funds_approved_id]'>".$$options."</select>";
	//判断是修改还是添加
	if(!empty($_GET[spend_funds_id])){
		//是修改
		//设置隐藏区域
		echo "<input type='hidden' name='spend_funds_id' value='".$_GET[spend_funds_id]."'/>";
		echo "<input type='hidden' name='spend_funds[spend_funds_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		//由给定的id获取数据
		$spend_funds_data=getTable('spend_funds','',$_GET[spend_funds_id]);
		$spend_funds_data=current($spend_funds_data);
		//print_r($spend_funds_data);
		//支出日期
		$data['支出日期']="<input type='date' name='spend_funds[spend_funds_date]' value=\"".date("Y-m-d",$spend_funds_data[spend_funds_date])."\" >";
		//设置隐藏区域
		echo "<input type='hidden' id='selected_purpose' value='".$spend_funds_data[spend_funds_purpose_id]."'/>";
		echo "<input type='hidden' id='selected_project' value='".$spend_funds_data[spend_funds_project_id]."'/>";
		echo "<input type='hidden' id='selected_approved_dept' value='".$spend_funds_data[spend_funds_aproved_dept_id]."'/>";
		echo "<input type='hidden' id='selected_benefit_dept' value='".$spend_funds_data[spend_funds_benefit_dept_id]."'/>";
		echo "<input type='hidden' id='selected_approved' value='".$spend_funds_data[spend_funds_approved_id]."'/>";
		echo "<input type='hidden' id='selected_manage' value='".$spend_funds_data[spend_funds_manage_id]."'/>";
		//echo $spend_funds_data[spend_funds_amount];
		//花费金额
		$data['支出金额']="<input type='text' id='spend_amount' name='spend_funds[spend_funds_amount]' value='".$spend_funds_data[spend_funds_amount]."' />";
		$data['备注']="<textarea name='spend_funds[spend_funds_remarks]'>".$spend_funds_data[spend_funds_remarks]."</textarea>";
		$table=new showTable($data);
		$table->Display("修改记录");
		//设置提交按钮
		echo "<input type='submit' name='update' value='修改'>";
		
	}else{
		//是添加
		$data['支出日期']="<input type='date' name='spend_funds[spend_funds_date]' value=\"".date("Y-m-d",time())."\">";
		//设置隐藏区域
		echo "<input type='hidden' name='spend_funds[spend_funds_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type='hidden' name='spend_funds[spend_funds_recorder_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type='hidden' id='selected_purpose' value=''/>";
		echo "<input type='hidden' id='selected_project' value=''/>";
		echo "<input type='hidden' id='selected_approved_dept' value=''/>";
		echo "<input type='hidden' id='selected_benefit_dept' value=''/>";
		echo "<input type='hidden' id='selected_approved' value=''/>";
		echo "<input type='hidden' id='selected_manage' value=''/>";
		//花费金额
		$data['支出金额']="<input type='text' id='spend_amount' name='spend_funds[spend_funds_amount]' value='".$spend_funds_data[spend_funds_amount]."' />";
		$data['备注']="<textarea name='spend_funds[spend_funds_remarks]'></textarea>";
		$table=new showTable($data);
		$table->Display("添加记录");
		echo "<input type='submit' name='insert' value='添加'>";
	}
?>
</form>
</body>
<script language="javascript">
			var selected_purpose=document.getElementById('selected_purpose').value;
			if(selected_purpose==''){
				selected_purpose=1;
			}
			document.getElementById('select_purpose').value=selected_purpose;
			var selected_project=document.getElementById('selected_project').value;
			if(selected_project==''){
				selected_project=1;
			}
			document.getElementById('select_project').value=selected_project;
			
			var selected_approved_dept=document.getElementById('selected_approved_dept').value;
			if(selected_approved_dept==''){
				selected_approved_dept=1;
			}
			document.getElementById('select_approved_dept').value=selected_approved_dept;
			
			var selected_benefit_dept=document.getElementById('selected_benefit_dept').value;
			if(selected_benefit_dept==''){
				selected_benefit_dept=1;
			}
			document.getElementById('select_benefit_dept').value=selected_benefit_dept;
			
			var selected_approved=document.getElementById('selected_approved').value;
			if(selected_approved==''){
				selected_approved=1;
			}
			document.getElementById('select_approved').value=selected_approved;
			
			var selected_manage=document.getElementById('selected_manage').value;
			if(selected_manage==''){
				selected_manage=1;
			}
			document.getElementById('select_manage').value=selected_manage;
			
			document.write("HELLO WORLD");
        </script>
</html>