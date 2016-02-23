<?php
//资金页面
session_start();
header("Content-Type:text/html;charset=utf8");
header("location:loadProject.php?loadProject=1");
if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('please login!');
				window.location.href='../notLogin.html';
			</script>
		";
	}
else{
	header("location:loadProject.php?loadProject=1");
}
//header("location:loadProject.php?loadProject=1");
?>