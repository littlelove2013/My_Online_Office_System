<?php
	if(empty($_GET[intercourse_id])){
		echo "<script language='javascript'>
				alert('出错');
				history.go(-1);
			</script>";
	}
	include("../../Tools/getMysqlDataFun.php");
	$result=deleteTableM("intercourse","intercourse_id=".$_GET[intercourse_id]);
	if($result){
		echo "<script language='javascript'>
				alert('成功');
				history.go(-3);
			</script>";
	}else{
		echo "<script language='javascript'>
				alert('失败');
				history.go(-1);
			</script>";
	}
?>