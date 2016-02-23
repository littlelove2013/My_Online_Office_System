<?php
	if(empty($_GET[donated_funds_id])){
		echo "<script language='javascript'>
				alert('出错');
				history.go(-1);
			</script>";
	}
	include("../../../../../Tools/getMysqlDataFun.php");
	$result=deleteTable("donated_funds",$_GET[donated_funds_id]);
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