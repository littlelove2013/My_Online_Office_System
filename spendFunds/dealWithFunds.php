<?php
	session_start();
	
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
		header("location:showFunds.php?pages=1");
	}
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
	$data=$_SESSION['spendloadfunds'];
	//print_r($data);
	if(empty($data)){	
		$_SESSION['spendfundsData']= array(array("支出资金"=>'无记录'));
	}else{
		//$allData=array_merge($personal_data,$group_data,$company_data);
		$tmpNullData=current($data);
		foreach($tmpNullData as $key=>$value){
			$tmpNullData[$key]='空';
		}
		$notNullData[]=$tmpNullData;
	}
	
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
	//筛选资金用途
	//purpose_type=>purpose_type_spend
	if(!empty($_GET[purpose_type])){
		$_SESSION[purpose_type_spend]=$_GET[purpose_type];
	}else{
		if(empty($_SESSION[purpose_type_spend])){
			$_SESSION[purpose_type_spend]='all';
		}
	}
	if($debug){
		echo "<br/>purpose_type:<br/>";
		echo $_SESSION[purpose_type_spend];
	}
	//执行部门进行筛选
	//approved_dept_spend
	if(!empty($_GET[approved_dept])){
		$_SESSION[approved_dept_spend]=$_GET[approved_dept];
	}else{
		if(empty($_SESSION[approved_dept_spend])){
			$_SESSION[approved_dept_spend]='all';
		}
	}
	if($debug){
		echo "<br/>approved_dept:<br/>";
		echo $_SESSION[approved_dept_spend];
	}
	//对批准人进行筛选
	//approved_spend
	if(!empty($_GET[approved])){
		$_SESSION[approved_spend]=$_GET[approved];
	}else{
		if(empty($_SESSION[approved_spend])){
			$_SESSION[approved_spend]='all';
		}
	}
	if($debug){
		echo "<br/>approved:<br/>";
		echo $_SESSION[approved_spend];
	}
	//对受益部门进行筛选
	//benefit_dept_spend
	if(!empty($_GET[benefit_dept])){
		$_SESSION[benefit_dept_spend]=$_GET[benefit_dept];
	}else{
		if(empty($_SESSION[benefit_dept_spend])){
			$_SESSION[benefit_dept_spend]='all';
		}
	}
	if($debug){
		echo "<br/>benefit_dept:<br/>";
		echo $_SESSION[benefit_dept_spend];
	}
	//对经办人进行筛选
	//fundrise_spend
	if(!empty($_GET[fundrise])){
		$_SESSION[fundrise_spend]=$_GET[fundrise];
	}else{
		if(empty($_SESSION[fundrise_spend])){
			$_SESSION[fundrise_spend]='all';
		}
	}
	if($debug){
		echo "<br/>fundrise:<br/>";
		echo $_SESSION[fundrise_spend];
	}
	$purpose_type=$_SESSION[purpose_type_spend];
	$approved_dept=$_SESSION[approved_dept_spend];
	$approved=$_SESSION[approved_spend];
	$benefit_dept=$_SESSION[benefit_dept_spend];
	$fundrise=$_SESSION[fundrise_spend];
	//echo "筛选用途:<br/>".$purpose_type."<br/>";
	$data=array_select($data,'资金用途',$purpose_type);
	if($debug){
		echo "<p>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
		return;
	}
	//筛选执行部门
	$data=array_select($data,'执行部门',$approved_dept);
	if($debug){
		echo "<p>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
		return;
	}
	//筛选批准人
	$data=array_select($data,'批准人',$approved);
	if($debug){
		echo "<p>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
		return;
	}
	//筛选受益部门
	$data=array_select($data,'受益部门',$benefit_dept);
	if($debug){
		echo "<p>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
		return;
	}
	//筛选经办人
	$data=array_select($data,'经办人',$fundrise);
	if($debug){
		echo "<p>";
		print_r($data);
	}
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
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
	$data=array_selectUpDown($data,'支出日期',$_SESSION[endTime],$_SESSION[startTime]);
	if(empty($data)){
		//为空，则返回
		$_SESSION['spendfundsData']=$notNullData;
		return;
	}
	if($debug){
		echo "<p>日期筛选检查后:</p>";
		print_r($data);
	}
	
	//由排序规则设置键名用于排序
	if(!empty($_GET[order_key])){
		$_SESSION[order_key]=$_GET[order_key];
	}else{
		if(empty($_SESSION[order_key])){
			$_SESSION[order_key]='支出日期';
		}
	}
	if($debug){
		echo "<br/>排序关键字：";
		echo $_SESSION[order_key];
	}
	$key=$_SESSION[order_key];
	//排序
	$tmpData=array();
	if($_SESSION['sortkey']){
		if($debug)
			echo "升序<p>";
		$tmpData=array_sort($data,$key,'asc');
	}else{
		if($debug)
			echo "降序<p>";
		$tmpData=array_sort($data,$key,'desc');
	}
	if($debug){
		echo "<br/>排序后：<p>";
		print_r($tmpData);
	}
	//setTimeToStr($tmpData,'支出日期');
	foreach($tmpData as $keys => $values){
			//print_r($values);
			$values['支出日期']= date("Y-m-d",$values['支出日期']);
			$values['编辑日期']= date("Y-m-d H:i:s",$values['编辑日期']);
			$tmpData[$keys]=$values;
			//print_r($values);
		}
	if($debug){
		echo "<br/>日期字符串化后：<p>";
		print_r($tmpData);
	}
	//
	
	$_SESSION['spendfundsData']=$tmpData;
	
	}

?>
</body>
</html>