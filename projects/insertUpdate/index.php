<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
	if(empty($_SESSION[USER_ID])){
		$USER_ID=$_SESSION[LOGIN_USER_ID];
		//将GB2312转换成UTF-8字符串
		$USER_ID=iconv('GB2312','UTF-8',$USER_ID);
		$_SESSION[USER_ID]=$USER_ID;
	}
	//if(empty($_SESSION[USER_ID])){
	//	$_SESSION[USER_ID]='龚成';
	//}
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
	
	
	//获取所有project_type
	$table="project_type";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($project_type);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['项目类型']="<select id='select_project_type' name='my_project[project_type_id]'>".$$options."</select>";
	//获取所有项目级别
	$table="project_level";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($project_level);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['项目级别']="<select id='select_project_level' name='my_project[project_level_id]'>".$$options."</select>";
	//获取所有项目状态
	$table="project_state";
	$$table=getTable($table,$table."_id as id,".$table."_name as name");
	if($debug){
		echo "<p>";
		print_r($project_state);
	}
	$options="options_".$table;
	foreach($$table as $keys=>$values){
		$$options.="<option value='".$values[id]."'>".$values[name]."</option>";
	}
	if($debug){
		echo "<br/><select>".$$options."</select><br/>";
	}
	$data['项目状态']="<select id='select_project_state' name='my_project[project_state_id]'>".$$options."</select>";
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
	$data['管理部门']="<select id='select_manage' name='my_project[project_manage_id]'>".$$options."</select>";
	//$data['受益部门']="<select id='select_benefit_dept' name='spend_funds[spend_funds_benefit_dept_id]'>".$$options."</select>";
	//获取所有筹款专员
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
	$data['筹款专员']="<select id='select_fundrise' name='my_project[project_fundrise_id]'>".$$options."</select>";
	//判断是修改还是添加
	if(!empty($_GET[project_id])){
		//是修改
		//设置隐藏区域
		echo "<input type='hidden' name='project_id' value='".$_GET[project_id]."'/>";
		echo "<input type='hidden' name='my_project[project_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		//由给定的id获取数据
		$project_data=getTable('project','',$_GET[project_id]);
		$project_data=current($project_data);
		//立项日期
		$data['立项日期']="<input type='date' name='my_project[project_date]' value=\"".date("Y-m-d",$project_data[project_date])."\" disabled=\"disabled\">";
		//设置隐藏区域
		echo "<input type='hidden' id='selected_project_type' value='".$project_data[project_type_id]."'/>";
		echo "<input type='hidden' id='selected_project_level' value='".$project_data[project_level_id]."'/>";
		echo "<input type='hidden' id='selected_project_state' value='".$project_data[project_state_id]."'/>";
		echo "<input type='hidden' id='selected_manage' value='".$project_data[project_manage_id]."'/>";
		echo "<input type='hidden' id='selected_fundrise' value='".$project_data[project_fundrise_id]."'/>";
		$data['项目名称']="<input type='text' name='my_project[project_name]' value=\"".$project_data[project_name]."\" />";
		$data['备注']="<textarea name='my_project[project_remarks]'>".$project_data[project_remarks]."</textarea>";
		$table=new showTable($data);
		$table->Display("修改项目");
		//设置提交按钮
		echo "<input type='submit' name='update' value='修改'>";
		
	}else{
		//是添加
		$data['立项日期']="<input type='date' name='my_project[project_date]' value=\"".date("Y-m-d",time())."\">";
		//设置隐藏区域
		echo "<input type='hidden' name='my_project[project_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type='hidden' name='my_project[project_recorder_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type='hidden' id='selected_project_type' value=''/>";
		echo "<input type='hidden' id='selected_project_level' value=''/>";
		echo "<input type='hidden' id='selected_project_state' value=''/>";
		echo "<input type='hidden' id='selected_manage' value=''/>";
		echo "<input type='hidden' id='selected_fundrise' value=''/>";
		$data['项目名称']="<input type='text' name='my_project[project_name]' value='' />";
		$data['备注']="<textarea name='my_project[project_remarks]'></textarea>";
		$table=new showTable($data);
		$table->Display("添加项目");
		echo "<input type='submit' name='insert' value='添加'>";
	}
?>
</form>
</body>
<script language="javascript">
			var selected_project_type=document.getElementById('selected_project_type').value;
			if(selected_project_type==''){
				selected_project_type=1;
			}
			document.getElementById('select_project_type').value=selected_project_type;
			var selected_project_level=document.getElementById('selected_project_level').value;
			if(selected_project_level==''){
				selected_project_level=1;
			}
			document.getElementById('select_project_level').value=selected_project_level;
			
			var selected_project_state=document.getElementById('selected_project_state').value;
			if(selected_project_state==''){
				selected_project_state=1;
			}
			document.getElementById('select_project_state').value=selected_project_state;
			
			var selected_manage=document.getElementById('selected_manage').value;
			if(selected_manage==''){
				selected_manage=1;
			}
			document.getElementById('select_manage').value=selected_manage;
			
			var selected_fundrise=document.getElementById('selected_fundrise').value;
			if(selected_fundrise==''){
				selected_fundrise=1;
			}
			document.getElementById('select_fundrise').value=selected_fundrise;
        </script>
</html>