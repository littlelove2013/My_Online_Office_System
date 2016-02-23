<?php
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('请您先登录本系统');
				window.location.href='../../notLogin.html';
			</script>
		";
	}
	$debug=false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客户列表</title>
</head>

<body>
<?php

	//添加显示类
	include("../../Tools/showPage.php");
	include("../../Tools/getMysqlDataFun.php");
	/*
	$personal_data=$_SESSION['personal_funds'];
	$group_data=$_SESSION['group_funds'];
	$company_data=$_SESSION['company_funds'];
	$_SESSION['sortkey']=0;
	*/
	$sortkey=$_SESSION['sortkey'];
	$customersData=$_SESSION['customersData'];
	//print_r($customersData);
	
	//$company_data=$tmp;
	
	$customersData_show=new showPage($customersData,"showCustomers.php");
	$customersData_show->setPageNum(10);
	$dataHead=$customersData_show->getDataHead();
	//print_r($dataHead);
	
	//设置隐藏值；
	echo "<input id='selected_customer_type' type='hidden' value=".$_SESSION[customers_customer_type]." />";
	$dataHead[0]="
		<select class='selectType' id=\"customer_type\" onchange=\"selectCustomerType()\">
			<option value=\"all\" >客户类型</option>
			<option value=\"个人\" >个人</option>
    		<option value=\"集体\" >集体</option>
    		<option value=\"机构\">机构</option>
		</select>
	";
	$dataHead[1]="<a id='thLink' href='dealWithCustomers.php?order_key=".$dataHead[1]."'>".$dataHead[1]."</a>";

	$customersData_show->setHead($dataHead);
	$customersData_show->setPagePrefix("customer_");
	//$intersourseData_show->setPageNum();
	$insertData="(<a href='operate/chooseType.php'>添加客户</a>)";
	$customersData_show->Display('客户管理'.$insertData);	
?>
<script language="javascript">
	//设置select的默认选项
	document.getElementById('customer_type').value=document.getElementById('selected_customer_type').value;
	//var type=document.getElementById('selected_customer_type');
	//document.write(type.value);
</script>
</body>

<script language="javascript">
	var sel = document.getElementById('customer_type');
	function selectCustomerType(){
		//document.write('进入函数');
		var sel = document.getElementById('customer_type');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithCustomers.php?customer_type='+sel.value;
		//document.write(sel.value);
	}
	function selectDate(){
		//document.write('你们好啊');
		//打开一个新页面
		//参数解释：   
//window.open 弹出新窗口的命令；   
//'page.html' 弹出窗口的文件名；   
//'newwindow' 弹出窗口的名字（不是文件名），非必须，可用空''代替；   
//height=100 窗口高度；   
//width=400 窗口宽度；   
//top=0 窗口距离屏幕上方的象素值；   
//left=0 窗口距离屏幕左侧的象素值；   
//toolbar=no 是否显示工具栏，yes为显示；   
//menubar，scrollbars 表示菜单栏和滚动栏。   
//resizable=no 是否允许改变窗口大小，yes为允许；   
//location=no 是否显示地址栏，yes为允许；   
//status=no 是否显示状态栏内的信息（通常是文件已经打开），yes为允许；   
		window.open ('selectDate.html', '按日期筛选', 'height=220, width=400, top=100px, left=200px, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')
	}
	function getStartDate(){
		return document.getElementById('startDate').value;
	}
	function getEndDate(){
		return document.getElementById('endDate').value;
	}
</script>

</html>