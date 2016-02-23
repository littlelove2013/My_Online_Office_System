<?php
	session_start();
	//print_r($_GET);
	//print_r($_SESSION);
	date_default_timezone_set('Asia/Shanghai');//设置为本地时间
	include("../Tools/getMysqlDataFun.php");
	if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('请您先登录本系统');
				window.location.href='../notLogin.html';
			</script>
		";
	}else{
		getData();
		header("location:showProject.php?pages=1");
	}
	$debug=false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dealWithFunds</title>
</head>

<body>
<?php
	function getData(){
		$debug=false;
	$data=$_SESSION['project'];
	//print_r($data);
	if(empty($data)){
		//echo "无任何数据";
		$_SESSION['projectData']= array("项目",'无记录');
		return;
	}else{
		//$allData=array_merge($personal_data,$group_data,$company_data);
		$tmpNullData=current($data);
		foreach($tmpNullData as $key=>$value){
			$tmpNullData[$key]='空';
		}
		$notNullData[]=$tmpNullData;
	}
	if($debug){
		echo "source:<br/>";
		print_r($data);
	}
	//print_r($data);
	//用get传递，customer_type传递捐赠人类型（all,personal,group,company）
	//用get传递，order_key传递排序规则(为字段，如‘捐赠时间’)，为空则不排序
	//用session传递，sortkey表示排序方向，为0则正序，为1则逆序，如果无排序字段则不排序
	if(empty($_SESSION['sortkey']))
	{
		$_SESSION['sortkey']=1;
	}else{
		if($_SESSION['sortkey']==1){
			$_SESSION['sortkey']=0;
		}else{
			$_SESSION['sortkey']=1;
		}
	}
	//筛选管理部门
	//manage_dept=>manage_dept_pro
	if(!empty($_GET[manage_dept])){
		$_SESSION[manage_dept_pro]=$_GET[manage_dept];
	}else{
		if(empty($_SESSION[manage_dept_pro])){
			$_SESSION[manage_dept_pro]='all';
		}
	}
	if($debug){
		echo "<br/>manage_dept:<br/>";
		echo $_SESSION[manage_dept];
	}
	//执行筹款专员进行筛选
	//fundeise_person=>fundrise_person_pro
	if(!empty($_GET[fundrise_person])){
		$_SESSION[fundrise_person_pro]=$_GET[fundrise_person];
	}else{
		if(empty($_SESSION[fundrise_person_pro])){
			$_SESSION[fundrise_person_pro]='all';
		}
	}
	if($debug){
		echo "<br/>fundrise_person:<br/>";
		echo $_SESSION[fundrise_person_pro];
	}
	//对项目类型进行筛选
	//project_type=>project_type_pro
	if(!empty($_GET[project_type])){
		$_SESSION[project_type_pro]=$_GET[project_type];
	}else{
		if( empty($_SESSION[project_type_pro]) ){
			$_SESSION[project_type_pro]='all';
		}
	}
	if($debug){
		echo "<br/>project_type:<br/>";
		echo $_SESSION[project_type_pro];
	}
	//对项目状态进行筛选
	//project_state=>project_state_pro
	if(!empty($_GET[project_state])){
		$_SESSION[project_state_pro]=$_GET[project_state];
	}else{
		if(empty($_SESSION[project_state_pro])){
			$_SESSION[project_state_pro]='all';
		}
	}
	if($debug){
		echo "<br/>project_state:<br/>";
		echo $_SESSION[project_state_pro];
	}
	//对项目级别进行筛选
	//project_level=>project_level_pro
	if(!empty($_GET[project_level])){
		$_SESSION[project_level_pro]=$_GET[project_level];
	}else{
		if(empty($_SESSION[project_level_pro])){
			$_SESSION[project_level_pro]='all';
		}
	}
	if($debug){
		echo "<br/>project_level:<br/>";
		echo $_SESSION[project_level_pro];
	}
	$manage_dept=$_SESSION[manage_dept_pro];
	$fundrise_person=$_SESSION[fundrise_person_pro];
	$project_type=$_SESSION[project_type_pro];
	$project_state=$_SESSION[project_state_pro];
	$project_level=$_SESSION[project_level_pro];
	$data=array_select($data,'管理部门',$manage_dept);
	if($debug){
		echo "<br/>筛选用途:".$manage_dept."<br/>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	//筛选执行部门
	$data=array_select($data,'筹款专员',$fundrise_person);
	//print_r($data);
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	//筛选批准人
	$data=array_select($data,'项目类型',$project_type);
	//print_r($data);
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	//筛选受益部门
	$data=array_select($data,'项目状态',$project_state);
	//print_r($data);
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	//筛选经办人
	$data=array_select($data,'项目级别',$project_level);
	if($debug){
		echo "筛选多项选择后:<br/>";
		print_r($data);
	}
	//print_r($data);
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	
	//筛选日期
	//echo "<p>筛选日期：</p>";
	//echo strtotime($_GET[startTime])."==>".strtotime($_GET[endTime]);
	
	if(!empty($_GET[startTime])){
		if($_GET[startTime]==1){
			//不做筛选
			$_SESSION[startTime]=0;
		}else
			$_SESSION[startTime]=strtotime($_GET[startTime]);
	}else{
		//如果没有设置开始日期
		if(empty($_SESSION[startTime])){
			//不做筛选
			$_SESSION[startTime]=0;
		}
	}
	if(!empty($_GET[endTime])){
		if($_GET[endTime]==1){
			//不做筛选
			$_SESSION[endTime]=0;
		}else
			$_SESSION[endTime]=strtotime($_GET[endTime]);
	}else{
		//如果没有设置开始日期
		if(empty($_SESSION[endTime])){
			//不做筛选
			$_SESSION[endTime]=0;
		}
	}
	//
	//echo "日期筛选：".$_SESSION[startTime]."=>".$_SESSION[endTime]."<p>";
	$data=array_selectUpDown($data,'立项日期',$_SESSION[endTime],$_SESSION[startTime]);
	if($debug){
		echo "筛选日期后:<br/>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['projectData']=$notNullData;
		return;
	}
	//echo "<p>日期筛选检查后:</p>";
	//print_r($data);
	
	//由排序规则设置键名用于排序
	if(!empty($_GET[order_key])){
		$_SESSION[order_key]=$_GET[order_key];
	}else{
		if(empty($_SESSION[order_key])){
			$_SESSION[order_key]='立项日期';
		}
	}
	$key=$_SESSION[order_key];
	//排序
	$tmpData=array();
	if($_SESSION['sortkey']){
		//echo "升序<p>";
		$tmpData=array_sort($data,$key,'asc');
	}else{
		//echo "降序<p>";
		$tmpData=array_sort($data,$key,'desc');
	}
	
	//setTimeToStr($tmpData,'立项日期');
	//setTimeToStr($tmpData,'编辑日期');
	foreach($tmpData as $keys => $values){
			//print_r($values);
			$values['立项日期']= date("Y-m-d",$values['立项日期']);
			$values['编辑日期']= date("Y-m-d H:i:s",$values['编辑日期']);
			$tmpData[$keys]=$values;
			//print_r($values);
		}
	//
	
	$_SESSION['projectData']=$tmpData;
	
	}

?>
</body>
</html>