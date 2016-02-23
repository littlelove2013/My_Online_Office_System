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
		//用header重定向的三个基本：
		//1、header前面不能有任何输出文本
		//2、location和：之间不能有空格
		//3、header跳转之后的代码还是会运行，所以如果跳转之后页面不再复用，最好加上exit()来结束本页面，如果不复用则可以不用结束
		header("location:showFunds.php");
		/*
		echo "
			<script language='javascript'>
				window.location.href='showFunds.php';
			</script>
		";
		*/
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
	$personal_data=$_SESSION['personal_funds'];
	$group_data=$_SESSION['group_funds'];
	$company_data=$_SESSION['company_funds'];
	if($debug){
		print_r($personal_data);
	}
	$allData=array();
	
	if(empty($personal_data) && empty($group_data) && empty($company_data)){
		$_SESSION['donatefundsData']= array(array("捐赠资金"=>'无记录'));
		//return;
	}else{
		$allData=array_merge($personal_data,$group_data,$company_data);
		$tmpNullData=current($allData);
		foreach($tmpNullData as $key=>$value){
			$tmpNullData[$key]='空';
		}
		$notNullData[]=$tmpNullData;
	}
	if($debug){
		echo "allData:<br/>";
		print_r($allData);
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
	$transData=array();
	if(!empty($_GET[customer_type])){
		$_SESSION[customer_type]=$_GET[customer_type];
	}else{
		if(empty($_SESSION[customer_type])){
			$_SESSION[customer_type]='all';
		}
	}
	$customer_type=$_SESSION[customer_type];
	
	if($debug){
		echo "<br/>customer_type:".$customer_type."<p>";
	}
	
	//获取想要的数据
	switch($customer_type){
		case 'all':
			$transData=$allData;
			break;
		case 'personal':
			if(empty($personal_data)){
				//$transData=$notNullData;
				$_SESSION['donatefundsData']=$notNullData;
				return;
			}else{
				$transData=$personal_data;
			}
			break;
		case 'group':
			if(empty($group_data)){
				//$transData=$notNullData;
				$_SESSION['donatefundsData']=$notNullData;
				return;
			}else{
				$transData=$group_data;
			}
			break;
		case 'company':
			if(empty($company_data)){
				//$transData=$notNullData;
				$_SESSION['donatefundsData']=$notNullData;
				return;
			}else{
				$transData=$company_data;
			}
			break;
	}
	
	if($debug){
		echo "<br/>tranData:<br/>";
		print_r($transData);
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
	$dateData=array_selectUpDown($transData,'捐赠时间',$_SESSION[endTime],$_SESSION[startTime]);
	if(empty($dateData)){
		//为空，则返回
		$_SESSION['donatefundsData']=$notNullData;
		return;
	}
	//由排序规则设置键名用于排序
	if(!empty($_GET[order_key])){
		$_SESSION[order_key]=$_GET[order_key];
	}else{
		if(empty($_SESSION[order_key])){
			$_SESSION[order_key]='捐赠时间';
		}
	}
	$key=$_SESSION[order_key];
	
	$tmpData=array();
	if($_SESSION['sortkey']){
		//echo "升序<p>";
		$tmpData=array_sort($dateData,$key,'asc');
	}else{
		//echo "降序<p>";
		$tmpData=array_sort($dateData,$key,'desc');
	}
	if($debug){
		print_r($tmpData);
	}
	//setTimeTypeToStr($tmpData);
	//把时间调成字符串
	foreach($tmpData as $keys => $values){
			//print_r($values);
			$values['捐赠时间']= date("Y-m-d",$values['捐赠时间']);
			$values['编辑时间']= date("Y-m-d H:i:s",$values['编辑时间']);
			$tmpData[$keys]=$values;
			//print_r($values);
	}
	$_SESSION['donatefundsData']=$tmpData;
	}
?>
</body>
</html>