<?php
	session_start();
	//print_r($_SESSION);
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
<title>项目展示</title>
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
	$projectData=$_SESSION['projectData'];
	
	
	//$company_data=$tmp;
	
	$projectData_show=new showPage($projectData,'showProject.php');
	$dataHead=$projectData_show->getDataHead();
	$dataHead[0]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[0]."'>".$dataHead[0]."</a>";
	$dataHead[1]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[1]."'>".$dataHead[1]."</a>";
	$dataHead[2]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[2]."'>".$dataHead[2]."</a>";
	$dataHead[3]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[3]."'>".$dataHead[3]."</a>";
	
	//设置隐藏值
	//echo $_SESSION[purpose_type]."<p>";
	//管理部门s
	echo "<input id='selected_manage_dept' type='hidden' value=\"".$_SESSION[manage_dept_pro]."\" />";
	//筹款专员
	echo "<input id='selected_fundrise_person' type='hidden' value=\"".$_SESSION[fundrise_person_pro]."\" />";
	//项目类型
	echo "<input id='selected_project_type' type='hidden' value=\"".$_SESSION[project_type_pro]."\" />";
	//项目状态
	echo "<input id='selected_project_state' type='hidden' value=\"".$_SESSION[project_state_pro]."\" />";
	//项目级别
	echo "<input id='selected_project_level' type='hidden' value=\"".$_SESSION[project_level_pro]."\" />";
	
	//$purpose_type=$_SESSION[purpose_type];
	//$approved_dept=$_SESSION[approved_dept];
	//$approved=$_SESSION[approved];
	//$benefit_dept=$_SESSION[benefit_dept];
	//$fundrise=$_SESSION[fundrise];
	
	//获取管理部门的值
	$pro_manage_dept=getTable('pro_manage_dept','pro_manage_dept_id as id,pro_manage_dept_name as name');
	$str='';
	foreach($pro_manage_dept as $keys=>$values){
		$str.="<option value=\"".$values[name]."\">".$values[name]."</option>";
	}
	$dataHead[4]="
		<select class='selectType' id=\"manage_dept\" onchange=\"select_manage_dept()\">
			<option value=\"all\" >所有管理部门</option> ".$str."
		</select>
	";
	//获取筹款专员的值
	$fundrise_person=getTable('fundrise_person','fundrise_person_id as id,fundrise_person_name as name');
	$str='';
	foreach($fundrise_person as $keys=>$values){
		$str.="<option value=\"".$values[name]."\">".$values[name]."</option>";
	}
	$dataHead[5]="
		<select class='selectType' id=\"fundrise_person\" onchange=\"select_fundrise_person()\">
			<option value=\"all\" >所有筹款专员</option> ".$str."
		</select>
	";
	
	//获取项目类型的值
	$project_type=getTable('project_type','project_type_id as id,project_type_name as name');
	$str='';
	foreach($project_type as $keys=>$values){
		$str.="<option value=\"".$values[name]."\">".$values[name]."</option>";
	}
	$dataHead[6]="
		<select class='selectType' id=\"project_type\" onchange=\"select_project_type()\">
			<option value=\"all\" >所有项目类型</option> ".$str."
		</select>
	";
	
	//获取项目状态的值
	$project_state=getTable('project_state','project_state_id as id,project_state_name as name');
	$str='';
	foreach($project_state as $keys=>$values){
		$str.="<option value=\"".$values[name]."\">".$values[name]."</option>";
	}
	$dataHead[7]="
		<select class='selectType' id=\"project_state\" onchange=\"select_project_state()\">
			<option value=\"all\" >所有项目状态</option> ".$str."
		</select>
	";
	//获取项目级别的值
	$project_level=getTable('project_level','project_level_id as id,project_level_name as name');
	$str='';
	foreach($project_level as $keys=>$values){
		$str.="<option value=\"".$values[name]."\">".$values[name]."</option>";
	}
	$dataHead[8]="
		<select class='selectType' id=\"project_level\" onchange=\"select_project_level()\">
			<option value=\"all\" >所有项目级别</option> ".$str."
		</select>
	";
	//$dataHead[10]="<a id='thLink' href='dealWithFunds.php?order_key=".$dataHead[10]."'>".$dataHead[10]."</a>";
	$dataHead[9]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[9]."'>".$dataHead[9]."</a>";
	$dataHead[10]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[10]."'>".$dataHead[10]."</a>";
	$dataHead[11]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[11]."'>".$dataHead[11]."</a>";
	$dataHead[12]="
				<div class='selectDate' width='100%'>
				<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[12]."'>".$dataHead[12]."</a>
				<img src='image/date_32.png' width='10%' height='10%' onclick='selectDate()'/>
				</div>";
	$dataHead[13]="<a id='thLink' href='dealWithProject.php?order_key=".$dataHead[13]."'>".$dataHead[13]."</a>";
	//setHead($dateHead);
	//echo "<p>";
	//print_r($dataHead);
	$projectData_show->setHead($dataHead);
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
	$insert="(<a href=\"insertUpdate/index.php\">添加项目</a>)";
	$projectData_show->Display('项目列表'.$insert."<br/>".$selectDateNow);	
	if( $debug ){
		echo "welcom to there<p>";
		print_r($_SESSION);
		echo "shuzune <p>";
	}
?>
</body>

<script language="javascript">
	var sel = document.getElementById('selected_manage_dept');
	document.getElementById('manage_dept').value=sel.value;
	document.getElementById('fundrise_person').value=document.getElementById('selected_fundrise_person').value;
	//document.write(document.getElementById('selected_fundrise_person').value);
	document.getElementById('project_type').value=document.getElementById('selected_project_type').value;
	document.getElementById('project_state').value=document.getElementById('selected_project_state').value;
	document.getElementById('project_level').value=document.getElementById('selected_project_level').value;
	function select_project_level(){
		//document.write('进入函数');
		var sel = document.getElementById('project_level');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithProject.php?project_level='+sel.value;
		//document.write(sel.value);
	}
	function select_project_state(){
		//document.write('进入函数');
		var sel = document.getElementById('project_state');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithProject.php?project_state='+sel.value;
		//document.write(sel.value);
	}
	function select_project_type(){
		//document.write('进入函数');
		var sel = document.getElementById('project_type');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithProject.php?project_type='+sel.value;
		//document.write(sel.value);
	}
	
	function select_manage_dept(){
		//document.write('进入函数');
		var sel = document.getElementById('manage_dept');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithProject.php?manage_dept='+sel.value;
		//document.write(sel.value);
	}
	function select_fundrise_person(){
		//document.write('进入函数');
		var sel = document.getElementById('fundrise_person');
		//document.getElementById('show').value='usgefiywef';
		window.location.href='dealWithProject.php?fundrise_person='+sel.value;
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