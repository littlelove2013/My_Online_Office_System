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
		header("location:showInters.php?pages=1");
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
		/*
	$personal_data=$_SESSION['personal_inters'];
	$group_data=$_SESSION['group_inters'];
	$company_data=$_SESSION['company_inters'];
	
	$allData=array();
	//intersourseData
	if(empty($personal_data) && empty($group_data) && empty($company_data)){
		echo "无任何数据";
		$_SESSION['intersourseData']= array("捐赠资金",'无');
		return;
	}else{
		$allData=array_merge($personal_data,$group_data,$company_data);
		$tmpNullData=current($allData);
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
	$transData=array();
	if(!empty($_GET[customer_type])){
		$_SESSION[inter_customer_type]=$_GET[customer_type];
	}else{
		if(empty($_SESSION[inter_customer_type])){
			$_SESSION[inter_customer_type]='all';
		}
	}
	$customer_type=$_SESSION[inter_customer_type];
	
	//获取想要的数据
	switch($customer_type){
		case 'all':
			$transData=$allData;
			break;
		case 'personal':
			if(empty($personal_data)){
				//$transData=$notNullData;
				$_SESSION['intersourseData']=$notNullData;
				return;
			}else{
				$transData=$personal_data;
			}
			break;
		case 'group':
			if(empty($group_data)){
				//$transData=$notNullData;
				$_SESSION['intersourseData']=$notNullData;
				return;
			}else{
				$transData=$group_data;
			}
			break;
		case 'company':
			if(empty($company_data)){
				//$transData=$notNullData;
				$_SESSION['intersourseData']=$notNullData;
				return;
			}else{
				$transData=$company_data;
			}
			break;
	}
	*/
	$intersData=$_SESSION['intersData'];
	if(empty($intersData)){
		$_SESSION['intersourseData']= array(array("捐赠资金",'无'));
	}else{
		$tmpNullData=current($intersData);
		foreach($tmpNullData as $key=>$value){
			$tmpNullData[$key]='空';
		}
		$notNullData[]=$tmpNullData;
	}
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
	$dateData=array();
	
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
	$dateData=array_selectUpDown($intersData,'交往日期',$_SESSION[endTime],$_SESSION[startTime]);
	if(empty($dateData)){
		//为空，则返回
		$_SESSION['intersourseData']=$notNullData;
		return;
	}
	//由排序规则设置键名用于排序
	if(!empty($_GET[order_key])){
		$_SESSION[order_key]=$_GET[order_key];
	}else{
		if(empty($_SESSION[order_key])){
			$_SESSION[order_key]='交往日期';
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
	
	//setTimeToStr($tmpData,'日期');
	foreach($tmpData as $keys => $values){
			//print_r($values);
			$values['交往日期']= date("Y-m-d",$values['交往日期']);
			$values['编辑日期']= date("Y-m-d H:i:s",$values['编辑日期']);
			$tmpData[$keys]=$values;
			//print_r($values);
		}
	//
	
	$_SESSION['intersourseData']=$tmpData;
	
	}

?>
</body>
</html>