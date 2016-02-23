<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
	//print_r($_SESSION);
	if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('请您先登录本系统');
				window.location.href='../notLogin.html';
			</script>
		";
	}
	$debug=false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资金展示</title>
</head>

<body>
<div>
	<a href="index.php" target="_top">
    	<img width="50" height="30" src="../image/submit.png" />
    </a>
</div>
<?php

	//添加显示类
	include("../Tools/showPage.php");
	include("../Tools/getMysqlDataFun.php");
	/*
	$personal_data=$_SESSION['personal_funds'];
	$group_data=$_SESSION['group_funds'];
	$company_data=$_SESSION['company_funds'];
	$_SESSION['sortkey']=0;
	*/
	$sortkey=$_SESSION['sortkey'];
	$fundsData=$_SESSION['spendfundsData'];
	
	
	//$company_data=$tmp;
	
	$fundsData_show=new showPage($fundsData,'showFunds.php');
	$dataHead=$fundsData_show->getDataHead();
	$dataHead[0]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[0]."'>".$dataHead[0]."</a>";
	$dataHead[1]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[1]."'>".$dataHead[1]."</a>";
	$dataHead[2]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[2]."'>".$dataHead[2]."</a>";
	//设置隐藏值
	//echo $_SESSION[purpose_type]."<p>";
	echo "<input id='selected_purpose_type' type='hidden' value=".$_SESSION[purpose_type_spend]." />";
	echo "<input id='selected_approved_dept' type='hidden' value=".$_SESSION[approved_dept_spend]." />";
	echo "<input id='selected_approved' type='hidden' value=".$_SESSION[approved_spend]." />";
	echo "<input id='selected_benefit_dept' type='hidden' value=".$_SESSION[benefit_dept_spend]." />";
	echo "<input id='selected_fundrise' type='hidden' value=".$_SESSION[fundrise_spend]." />";
	//$purpose_type=$_SESSION[purpose_type];
	//$approved_dept=$_SESSION[approved_dept];
	//$approved=$_SESSION[approved];
	//$benefit_dept=$_SESSION[benefit_dept];
	//$fundrise=$_SESSION[fundrise];
	
	//获取资金用途的值
	$purpose=getTable('purpose','purpose_id as id,purpose_name as name');
	$str='';
	foreach($purpose as $keys=>$values){
		$str.="<option value='".$values[name]."'>".$values[name]."</option>";
	}
	$dataHead[3]="
		<select class='selectType' id=\"purpose_type\" onchange=\"selectCustomerType()\">
			<option value=\"all\" >所有资金用途</option> ".$str."
		</select>
	";
	//获取执行部门的值
	$approved_dept=getTable('pro_manage_dept','pro_manage_dept_id as id,pro_manage_dept_name as name');
	$str='';
	foreach($approved_dept as $keys=>$values){
		$str.="<option value='".$values[name]."'>".$values[name]."</option>";
	}
	$dataHead[6]="
		<select class='selectType' id=\"approved_dept\" onchange=\"select_approved_dept()\">
			<option value=\"all\" >所有执行部门</option> ".$str."
		</select>
	";
	//获取批准人的值
	$approved=getTable('approved','approved_id as id,approved_name as name');
	$str='';
	foreach($approved as $keys=>$values){
		$str.="<option value='".$values[name]."'>".$values[name]."</option>";
	}
	$dataHead[7]="
		<select class='selectType' id=\"approved\" onchange=\"select_approved()\">
			<option value=\"all\" >所有批准人</option> ".$str."
		</select>
	";
	//获取受益部门的值
	//$benefit_dept=getTable('pro_manage_dept','pro_manage_dept_id as id,pro_manage_dept_name as name');
	$benefit_dept=$approved_dept;
	$str='';
	foreach($benefit_dept as $keys=>$values){
		$str.="<option value='".$values[name]."'>".$values[name]."</option>";
	}
	$dataHead[8]="
		<select class='selectType' id=\"benefit_dept\" onchange=\"select_benefit_dept()\">
			<option value=\"all\" >所有受益部门</option> ".$str."
		</select>
	";
	//获取经办人的值
	$fundrise_person=getTable('fundrise_person','fundrise_person_id as id,fundrise_person_name as name');
	$str='';
	foreach($fundrise_person as $keys=>$values){
		$str.="<option value='".$values[name]."'>".$values[name]."</option>";
	}
	$dataHead[9]="
		<select class='selectType' id=\"fundrise\" onchange=\"select_fundrise()\">
			<option value=\"all\" >所有经办人</option> ".$str."
		</select>
	";
	//$dataHead[10]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[10]."'>".$dataHead[10]."</a>";
	$dataHead[10]="
				<div class='selectDate' width='100%'>
				<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[10]."'>".$dataHead[10]."</a>
				<img src='image/date_32.png' width='10%' height='10%' onclick='selectDate()'/>
				</div>";
	//setHead($dateHead);
	//echo "<p>";
	//print_r($dataHead);
	$fundsData_show->setHead($dataHead);
	//$fundsData_show->setPageNum();
	//设置显示当前筛选日期
	$selectDateNow='';
	if($_SESSION[startTime]==0&&$_SESSION[endTime]==0){
		//什么也不做
	}else{
		$selectDateNow.='(当前筛选时间为：';
		if($_SESSION[startTime]!=0){
			$selectDateNow.=date("Y-m-d H:i:s",$_SESSION[startTime]).' 到 ';
			//设置隐藏域
			echo "<input type=\"hidden\" id='startDate' value=".date("Y-m-d H:i:s",$_SESSION[startTime])."/>";
		}else{
			$selectDateNow.='最小日期 到 ';
		}
		if($_SESSION[endTime]!=0){
			$selectDateNow.=date("Y-m-d H:i:s",$_SESSION[endTime]).")";
			//设置隐藏域
			echo "<input type=\"hidden\" id='endDate' value=".date("Y-m-d H:i:s",$_SESSION[endTime])."/>";
		}else{
			$selectDateNow.='最大日期)';
		}
		
	}
	//设置添加支出菜单
	$insert="(<a href='insertUpdate/index.php'>添加支出记录</a>)";
	$fundsData_show->Display('支出资金'.$insert."<br/>".$selectDateNow);	
	if( $debug ){
		echo "welcom to there<p>";
		print_r($_SESSION);
		echo "shuzune <p>";
	}
?>
<script language="javascript">
	//设置select的默认选项
	document.getElementById('customer_type').value=document.getElementById('selected_customer_type').value;
	//var type=document.getElementById('selected_customer_type');
	//document.write(type.value);
</script>
</body>

<script language="javascript">
	var sel = document.getElementById('selected_purpose_type');
	document.getElementById('purpose_type').value=sel.value;
	document.getElementById('approved_dept').value=document.getElementById('selected_approved_dept').value;
	document.getElementById('approved').value=document.getElementById('selected_approved').value;
	document.getElementById('benefit_dept').value=document.getElementById('selected_benefit_dept').value;
	document.getElementById('fundrise').value=document.getElementById('selected_fundrise').value;
	function selectCustomerType(){
		//document.write('进入函数');
		var sel = document.getElementById('purpose_type');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithFunds.php?purpose_type='+sel.value;
		//document.write(sel.value);
	}
	function select_approved_dept(){
		var sel = document.getElementById('approved_dept');
		//document.write(sel.value);
		window.location.href='dealWithFunds.php?approved_dept='+sel.value;
	}
	function select_approved(){
		var sel = document.getElementById('approved');
		//document.write(sel.value);
		window.location.href='dealWithFunds.php?approved='+sel.value;
	}
	function select_benefit_dept(){
		var sel = document.getElementById('benefit_dept');
		window.location.href='dealWithFunds.php?benefit_dept='+sel.value;
	}
	function select_fundrise(){
		var sel = document.getElementById('fundrise');
		window.location.href='dealWithFunds.php?fundrise='+sel.value;
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
		window.open ('selectDate.php', '按日期筛选', 'height=220, width=400, top=100px, left=200px, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')
	}
	function getStartDate(){
		return document.getElementById('startDate').value;
	}
	function getEndDate(){
		return document.getElementById('endDate').value;
	}
</script>

</html>