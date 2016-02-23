<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
<?php
	if(empty($_GET[id])){
		echo __LINE__.":出错<p>";
		return;
	}
	include("../../../Tools/getMysqlDataFun.php");
	$isDelete=deleteTable('news',$_GET[id]);
	if($isDelete)
	{
		echo "
			<script language='javascript'>
				alert('删除成功');
				window.location.href('index.php');
			</script>
		";
	}else{
		echo "
			<script language='javascript'>
				alert('删除失败');
				window.location.href('index.php');
			</script>
		";
	}
?>
</body>
</html>