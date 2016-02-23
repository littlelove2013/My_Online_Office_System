<?php
//获取一个spend_funds_id,
if(empty($_GET[spend_funds_id])){
	echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../Others/noItemSelect.html';
			</script>
		";
}
//进行删除
include("../../Tools/getMysqlDataFun.php");
$id=$_GET[spend_funds_id];
$result=deleteTable("spend_funds",$id);
if($result){
	//删除成功
	echo "
			<script language='javascript'>
				alert('删除成功!');
				history.go(-2);
			</script>
		";
}else{
	//删除失败
	echo "
			<script language='javascript'>
				alert('删除失败!');
				history.go(-2);
			</script>
		";
}
?>