<?php
	session_start();
	header("Content-Type:text/html;charset=utf8");
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
	include("showPage.php");
	/*
	$personal_data=$_SESSION['personal_funds'];
	$group_data=$_SESSION['group_funds'];
	$company_data=$_SESSION['company_funds'];
	$_SESSION['sortkey']=0;
	*/
	$sortkey=$_SESSION['sortkey'];
	$fundsData=$_SESSION['donatefundsData'];
	
	
	//$company_data=$tmp;
	
	$fundsData_show=new showPage($fundsData);
	$fundsData_show->setPageNum(10);
	$dataHead=$fundsData_show->getDataHead();
	//echo "<p>";
	//print_r($dataHead);
	//function setHead(&$dateHead){
//		foreach($dataHead as $key=>$value){
	//		$dataHead[$key]="<a id='thLink' href='dealWithFunds.php?order_key=".$value."'>".$value."</a>";
	//	}
	//}
	function setHead(&$dateHead,$key){
		
	}
	//setHead($dataHead);
	//echo "<p>";
	//print_r($dataHead);
	//foreach($dataHead as $key=>$value){
	//	$dataHead[$key]="<a id='thLink' href='dealWithFunds.php?order_key=".$value."'>".$value."</a>";
	//}
	$dataHead[0]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[0]."'>".$dataHead[0]."</a>";
	$dataHead[1]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[1]."'>".$dataHead[1]."</a>";
	//$dataHead[2]="";
	/*
	$dataHead[3]="
	<ul class='type'>
		<li>".$dataHead[3]."
    		<ul>
				<li class='secondary_menu'><a id='thLink' href='#'>全部</a></li>
        		<li class='secondary_menu'><a id='thLink' href='#'>个人捐赠</a></li>
            	<li class='secondary_menu'>集体捐赠</li>
            	<li class='secondary_menu'>机构捐赠</li>    
        	</ul>
    	</li>
	</ul>";
	*///设置选中
	/*
	switch($_SESSION[customer_type]){
		case 'all':
			$selectAll="selected='selected'";
			break;
		case 'personal':
			$selectPersonal="selected='selected'";
			break;
		case 'group':
			$selectGroup="selected='selected'";
			break;
		case 'company':
			$selectCompany="selected='selected'";
			break;
	}*/
	//设置隐藏值；
	echo "<input id='selected_customer_type' type='hidden' value=".$_SESSION[customer_type]." />";
	$dataHead[3]="
		<select class='selectType' id=\"customer_type\" onchange=\"selectCustomerType()\">
			<option value=\"all\" ".$selectAll.">全部</option>
			<option value=\"personal\" ".$selectPersonal.">个人捐赠</option>
    		<option value=\"group\" ".$selectGroup.">集体捐赠</option>
    		<option value=\"company\" ".$selectCompany.">机构捐赠</option>
		</select>
	";
	$dataHead[4]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[4]."'>".$dataHead[4]."</a>";
	$dataHead[7]="
				<div class='selectDate' width='100%'>
				<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[7]."'>".$dataHead[7]."</a>
				<img src='image/date_32.png' width='10%' height='10%' onclick='selectDate()'/>
				</div>";
	$dataHead[8]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[8]."'>".$dataHead[8]."</a>";
	//setHead($dateHead);
	//echo "<p>";
	//print_r($dataHead);
	$fundsData_show->setHead($dataHead);
	$fundsData_show->setPageNum();
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
	$insert="(<a href='addDonatedFunds.php'>添加捐赠记录</a>)";
	$fundsData_show->Display('捐赠资金'.$insert."<br/>".$selectDateNow);	
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
	var sel = document.getElementById('customer_type');
	function selectCustomerType(){
		//document.write('进入函数');
		var sel = document.getElementById('customer_type');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithFunds.php?customer_type='+sel.value;
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