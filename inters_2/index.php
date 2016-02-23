<?php
//资金页面
session_start();
header("Content-Type:text/html;charset=utf8");
if(empty($_SESSION)){
		echo "
			<script language='javascript'>
				alert('please login!');
				window.location.href='../notLogin.html';
			</script>
		";
	}
else{
	header("location:loadInters.php?loadInters=1");
}
header("location:loadInters.php?loadInters=1");
?>