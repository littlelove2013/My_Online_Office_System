<?php
	session_start();
	$_SESSION[is_delete]=true;
	if(!$_GET[loadInters]){
		echo "
			<script language='javascript'>
				alert('参数不正确');
				window.location.href='../notLogin.html';
			</script>
		";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LoadFunds</title>
<link href="../CSS/loading.css" rel="stylesheet" type="text/css" />
</head>

<body class="loading">
<div class="loading">
	<img src="../image/loading.gif" />
    <p>LOADING......</p>
</div>
<?php
	header("Content-Type:text/html;charset=utf8");
	$debug=false;
	include("inc/DB/Mode.php");
	
	$loadInters=new Mode("intercourse");
	if ($debug){
		$data=$loadInters->select();
		print_r($data);
	}
	
	//获取所有交往记录
	$table="intercourse";
	$field="
			intercourse_id as id,
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '交往日期',
		intercourse_lastedit_date as '编辑日期'
	";
	$loadInters->setOptionsTable($table);
	$loadInters->setOptionsField($field);
	$allData=$loadInters->select();
	//为每个数组加上操作菜单
	/*
	$data=$personal_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href='insertUpdate/index.php?intercourse_id=".$values[id]."'>编辑</a>";
		$delete="<br/><a href='insertUpdate/deleteP.php?intercourse_id=".$values[id]."'>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['personal_inters']=$data;
	$data=$group_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href='insertUpdate/index.php?intercourse_id=".$values[id]."'>编辑</a>";
		$delete="<br/><a href='insertUpdate/deleteP.php?intercourse_id=".$values[id]."'>删除本次记录(谨慎)</a>	";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['group_inters']=$data;
	$data=$company_data;
	foreach($data as $keys=>$values){
		$values['操作']="<a href='insertUpdate/index.php?intercourse_id=".$values[id]."'>编辑</a>";
		$delete="<br/><a href='insertUpdate/deleteP.php?intercourse_id=".$values[id]."'>删除本次记录(谨慎)</a>";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$data[$keys]=$values;
	}
	$_SESSION['company_inters']=$data;
	*/
	foreach($allData as $keys=>$values){
		$values['操作']="<a href='insertUpdate/index.php?intercourse_id=".$values[id]."'>编辑</a>";
		$delete="<br/><a href='insertUpdate/deleteP.php?intercourse_id=".$values[id]."'>删除本次记录(谨慎)</a>";
		if($_SESSION[is_delete]==true){
			$values['操作'].=$delete;
		}
		$values['活动主题']="<a id='table_td' href='oneIntersShow/index.php?intercourse_id=".$values[id]."'>".$values['活动主题']."</a>";
		$data[$keys]=$values;
	}
	$_SESSION['intersData']=$data;
	//print_r($_SESSION['company_funds']);
	//header('Location: '.'showFunds.php');
	//header("refresh:1;url=dealWithInters.php");
	echo "
		<script language='javascript'>
				window.location.href='dealWithInters.php';
		</script>
	";
?>
</body>
</html>