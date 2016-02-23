<?php
	session_start();
	//date_default_timezone_set('Asia/Shanghai');//设置为本地时间
	if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('请您先登录本系统');
				window.location.href='../../notLogin.html';
			</script>
		";
	}else{
		
		getData();
		header("location:showCustomers.php?pages=1");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dealWithCustomers</title>
</head>

<body>
<?php
	function getData(){
		$debug=false;
	$personal_data=$_SESSION['personal_customers'];
	$group_data=$_SESSION['group_customers'];
	$company_data=$_SESSION['company_customers'];
	
	$allData=array();
	//intersourseData
	if(empty($personal_data) && empty($group_data) && empty($company_data)){
		//echo "无任何数据";
		$_SESSION['customersData']= array("捐赠资金",'无');
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
		$_SESSION[customers_customer_type]=$_GET[customer_type];
	}else{
		if(empty($_SESSION[customers_customer_type])){
			$_SESSION[customers_customer_type]='all';
		}
	}
	$customer_type=$_SESSION[customers_customer_type];
	
	//获取想要的数据
	switch($customer_type){
		case 'all':
			$transData=$allData;
			break;
		case '个人':
			if(empty($personal_data)){
				//$transData=$notNullData;
				$_SESSION['customersData']=$notNullData;
				return;
			}else{
				$transData=$personal_data;
			}
			break;
		case '集体':
			if(empty($group_data)){
				//$transData=$notNullData;
				$_SESSION['customersData']=$notNullData;
				return;
			}else{
				$transData=$group_data;
			}
			break;
		case '机构':
			if(empty($company_data)){
				//$transData=$notNullData;
				$_SESSION['customersData']=$notNullData;
				return;
			}else{
				$transData=$company_data;
			}
			break;
	}
	//$dateData=array();
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
		$tmpData=array_sort($transData,$key,'asc');
	}else{
		//echo "降序<p>";
		$tmpData=array_sort($transData,$key,'desc');
	}
	
	//setTimeTypeToStr($tmpData);
	//
	if($debug){
		print_r($tmpData);
	}
	//排序之后，为每一条记录加上处理菜单
	foreach($tmpData as $keys=>$values){
		$values['操作']="<a href='operate/insertUpdate.php?customer_type=".$values['客户类型']."&customer_id=".$values[id]."'>编辑</a>&nbsp;&nbsp;
						<a href='operate/deleteP.php?customer_type=".$values['客户类型']."&customer_id=".$values[id]."'>删除</a>";
		//给每个值加上处理链接
		$values['name']="<a id='table_td' href='oneCustomerShow/index.php?customer_type=".$values['客户类型']."&customer_id=".$values[id]."' target='_top'>".$values['name']."</a>";
		$values['客户类型']="<a id='table_td' href='dealWithCustomers.php?customer_type=".$values['客户类型']."' >".$values['客户类型']."</a>";
		unset($values[id]);
		$tmpData[$keys]=$values;
	}
	$_SESSION['customersData']=$tmpData;
	
	}
	/*二维数组按指定的键值排序*/
	function array_sort($array,$keys,$type='asc'){
		if(!isset($array) || !is_array($array) || empty($array)){
  			return '';
 		}
 		if(!isset($keys) || trim($keys)==''){
 	 		return '';
 		}
 		if(!isset($type) || $type=='' || !in_array(strtolower($type),array('asc','desc'))){
  			return '';
 		}
 		$keysvalue=array();
 		foreach($array as $key=>$val){
  			$val[$keys] = str_replace('-','',$val[$keys]);
  			$val[$keys] = str_replace(' ','',$val[$keys]);
  			$val[$keys] = str_replace(':','',$val[$keys]);
  			$keysvalue[$key] =$val[$keys];
 		}
 		asort($keysvalue); //key值排序
 		reset($keysvalue); //指针重新指向数组第一个
 		foreach($keysvalue as $key=>$vals) {
  			$keysort[] = $key;
 		}
 		$keysvalue = array();
 		$count=count($keysort);
		//echo __LINE__.":进入排列<p>";
 		if(strtolower($type) != 'asc'){
			//echo __LINE__.":进入降序排列<p>";
  			for($i=$count-1; $i>=0; $i--) {
   			$keysvalue[] = $array[$keysort[$i]];
  		}
 		}else{
  			for($i=0; $i<$count; $i++){
   				$keysvalue[] = $array[$keysort[$i]];
  			}
 		}
 		return $keysvalue;
	}

?>
</body>
</html>