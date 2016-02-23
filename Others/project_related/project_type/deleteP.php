<?php
	if(empty($_GET[id])){
		echo __LINE__.":出错<p>";
		return;
	}
	include("../../../Tools/getMysqlDataFun.php");
	$table='project_type';
	$isDelete=deleteTable($table,$_GET[id]);
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