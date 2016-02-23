<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
	//$_SESSION[USER_ID]="徐志江";
	if(empty($_SESSION[USER_ID])){
		$USER_ID=$_SESSION[LOGIN_USER_ID];
		//将GB2312转换成UTF-8字符串
		$USER_ID=iconv('GB2312','UTF-8',$USER_ID);
		$_SESSION[USER_ID]=$USER_ID;
	}
	echo "USER_ID:".$_SESSION[USER_ID]."<p>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>
<body>

<form name="insertUpdateDonated" method="post" action="deal.php">
<?php
	//echo '欢迎添加纪录<p>';
	include("../../Tools/showPage.php");
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showTable.php");
	//数组为insertIntercourse
	//这里开始建表
	$customer_data=array();//$data用于存储查找到的用户列表
	$select='';
	
	//获取个人列表
	$personal_data=getTable('personal','personal_id as id,personal_name as name');
	//获取集体列表
	$group_data=getTable('group','group_id as id,group_name as name');	
	//获取机构列表
	$company_data=getTable('company','company_id as id,company_name as name');		
	if(!empty($_GET[intercourse_id])){
		//先查找本身存在的联系
		$join_intercourse=getTableM("join_intercourse","","intercourse_intercourse_id=".$_GET[intercourse_id]);
		//echo "join_intercourse:<br/>";
		//print_r($join_intercourse);
		//分别用数组存放
		$personal_info=array();
		$company_info=array();
		$group_info=array();
		foreach($join_intercourse as $keys=>$values){
			if(!empty($values[personal_personal_id])){
				$personal_info[]=$values[personal_personal_id];
			}
			if(!empty($values[group_group_id])){
				$group_info[]=$values[group_group_id];
			}
			if(!empty($values[company_company_id])){
				$company_info[]=$values[company_company_id];
			}
		}
		//echo "personal_info:<br/>";
		//print_r($personal_info);
	//已知用户类型
	//switch($_GET[customer_type]){
		//case '个人':
				//echo "personal<p>";
				//设置隐藏域
				//echo "<input type=\"hidden\" name='insertIntercourse[group_group_id]' value=''/>";
				//echo "<input type=\"hidden\" name='insertIntercourse[company_company_id]' value=''/>";
				//改为多项选择框
				$personal_checkBox="";
				foreach($personal_data as $keys=>$values){
					//设置每一项的值
					if(in_array($values[id],$personal_info)){
						$checked="checked='checked'";
					}else{
						$checked="";
					}
					$personal_checkBox.="<input type='checkbox' name='insertJoinIntercourse[personal_personal_id][]' ".$checked." value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
				/*
				$select="<select id='selectCustomer' name='insertIntercourse[personal_personal_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value=\"". $values[id] ."\">".$values[name]."</option>";
				}
				$select.="</select>";
				*/
				//print_r($data);
					//	break;
		//case '集体':
				$group_checkBox="";
				foreach($group_data as $keys=>$values){
					//设置每一项的值
					if(in_array($values[id],$group_info)){
						$checked="checked='checked'";
					}else{
						$checked="";
					}
					$group_checkBox.="<input type='checkbox' name='insertJoinIntercourse[group_group_id][]' ".$checked." value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
				//设置隐藏域
				//echo "<input type=\"hidden\" name='insertIntercourse[personal_personal_id]' value=''/>";
				//echo "<input type=\"hidden\" name='insertIntercourse[company_company_id]' value=''/>";
				/*
				$select="<select id='selectCustomer' name='insertIntercourse[group_group_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value=\"". $values[id] ."\">".$values[name]."</option>";
				}
				$select.="</select>";
				*/
					//	break;
		//case '机构':
				
				$company_checkBox="";
				foreach($company_data as $keys=>$values){
					//设置每一项的值
					if(in_array($values[id],$company_info)){
						$checked="checked='checked'";
					}else{
						$checked="";
					}
					$company_checkBox.="<input type='checkbox' name='insertJoinIntercourse[company_company_id][]' ".$checked." value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
				//设置隐藏域
				//echo "<input type=\"hidden\" name='insertIntercourse[personal_personal_id]' value=''/>";
				//echo "<input type=\"hidden\" name='insertIntercourse[group_group_id]' value=''/>";
				/*
				$select="<select id='selectCustomer' name='insertIntercourse[company_company_id]'>";
				foreach($customer_data as $keys=>$values){
					//设置每一项的值
					$select.="<option value=\"". $values[id] ."\">".$values[name]."</option>";
				}
				$select.="</select>";
				*/
					//	break;
	//}
	}else{
		$personal_checkBox="";
				foreach($personal_data as $keys=>$values){
					//设置每一项的值
					$personal_checkBox.="<input type='checkbox' name='insertJoinIntercourse[personal_personal_id][]' value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
		$group_checkBox="";
				foreach($group_data as $keys=>$values){
					//设置每一项的值
					$group_checkBox.="<input type='checkbox' name='insertJoinIntercourse[group_group_id][]' value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
		$company_checkBox="";
				foreach($company_data as $keys=>$values){
					//设置每一项的值
					$company_checkBox.="<input type='checkbox' name='insertJoinIntercourse[company_company_id][]' value=\"". $values[id] ."\">".$values[name]."<br/>";
				}
	}
	//print_r($customer_data);
	
	//设置显示数据data
	$data=array(
				'参与个人客户'=>$personal_checkBox,
				'参与集体客户'=>$group_checkBox,
				'参与机构客户'=>$company_checkBox);
	
	if(!empty($_GET[intercourse_id])){
		//则说明是对一次已存在的资金进行修改
		//设置隐藏域
		echo "<input type=\"hidden\" name='intercourse_id' value='".$_GET[intercourse_id]."'/>";
		//先获取本次资金的信息
		$myIntercourse=getTable("intercourse",'',$_GET[intercourse_id]);
		$myIntercourse=current($myIntercourse);
		
		$data['交往时间']="<input type='date' name='insertIntercourse[intercourse_date]' value=\"".date("Y-m-d",$myIntercourse[intercourse_date])."\" >";
	
		$data['主题']="<input type=text name='insertIntercourse[intercourse_theme]' value=\"".$myIntercourse['intercourse_theme']."\"/>";
		//备注
		$data['内容']="<textarea name='insertIntercourse[intercourse_content]'>".$myIntercourse['intercourse_content']."</textarea>";
		//只需要改最后编辑人
		echo "<input type=\"hidden\" name='insertIntercourse[intercourse_lastedit_id]' value=\"".$_SESSION[USER_ID]."\"/>";
		
		
		//显示内容
		$change=new showTable($data);
		$change->Display("更改交往记录");
		
		echo "<input type='submit' name='update' value='修改'/>";
		
	}else{
		$data['交往时间']="<input type='date' name='insertIntercourse[intercourse_date]' value=\"".date("Y-m-d",time())."\">";
		
		$data['主题']="<input type=text name='insertIntercourse[intercourse_theme]' value=\"\"/>";
		//备注
		$data['内容']="<textarea name='insertIntercourse[intercourse_content]'></textarea>";
		
		//第一次最后编辑人和记录人是同一人
		echo "<input type=\"hidden\" name='insertIntercourse[intercourse_recorder_id]' value='".$_SESSION[USER_ID]."'/>";
		echo "<input type=\"hidden\" name='insertIntercourse[intercourse_lastedit_id]' value='".$_SESSION[USER_ID]."'/>";
		$add=new showTable($data);
		$add->Display("添加交往记录");
		
		echo "<input type='submit' name='insert' value='添加'/>";
	}
?>

</form>
</body>
</html>