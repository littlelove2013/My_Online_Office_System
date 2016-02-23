<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test1</title>
</head>

<body>


<?php
	//添加显示类
	include("showPage.php");
	/*
	$array=array(array('124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj'),
			array('124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj'),
			array('124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj','124'=>'djkfghj')
			);
	$test = new showPage($array);
	$test->Display();
	*/
	$arr=array('1'=>4,'sdf'=>9,7,8);
	sort($arr);
	print_r($arr);
	echo "<p>";
	print_r($_POST);
	if(!empty($_POST)){
		$time=strtotime($_POST[user_date]);
		echo $time."<br/>";
		echo date("Y-m-d H:i:s",$time);
	}
	if(!empty($_GET)){
		print_r($_GET);
	}
?>
<div>
<select id="customer_type" onchange="selectCustomerType()">
	<option value="all">全部</option>
	<option value="personal"><a href="www.baidu.com">个人捐赠</a></option>
    <option value="group">集体捐赠</option>
    <option value="company">机构捐赠</option>
</select>
</div>
<div id='show'>
	
</div>
<div>
	<form name='testData' action="" method="post">
		<input type="datetime-local" name="user_date" placeholder="请输入日期" />
        <input type="submit" value="提交"/>
    </form>
</div>
</body>
<script language="javascript">
	window.open ('test2.html', 'newwindow', 'height=100, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no')
	function selectCustomerType(){
		//document.write('进入函数');
		//var sel = document.getElementById('customer_type');
		//document.getElementById('show').value='usgefiywef';
		document.getElementById('show').innerHTML='进入函数';
		//document.write(sel.value);
	}
</script>
</html>
