<?php
	if(empty($_GET[customer_type]) ){
			//没有传递客户类型，则报错
			echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	if($_POST[insert]=='添加'){
		switch($_GET[customer_type]){
		case '个人':
		$data=$_POST[personal];
		print_r($data);
			break;
		case '集体':
		//获取集体的值
		$data=$_POST[group];
		print_r($data);
			break;
		case '机构':
		//获取机构的值
		$data=$_POST[company];
		print_r($data);
			break;
		}
	}
?>