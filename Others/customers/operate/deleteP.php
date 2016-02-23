<?php
	header("Content-Type:text/html;charset=utf8");
	if( empty($_GET[customer_type]) || empty($_GET[customer_id]) ){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	include("../../../Tools/getMysqlDataFun.php");
	//做删除
	switch($_GET[customer_type]){
		case '个人':
		if(deleteTable('personal',$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('删除成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('删除失败');
						window.location.href('../showCustomers.php?pages=1');
					</script>
					";
		}
			break;
		case '集体':
		if(deleteTable('group',$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('删除成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('删除失败');
						window.location.href('../showCustomers.php?pages=1');
					</script>
					";
					
		}
			break;
		case '机构':
		if(deleteTable('company',$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('删除成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('删除失败\\nTips:带*为必填项');
						window.location.href('../showCustomers.php?pages=1');
					</script>
					";
					
		}
			break;
		}
?>