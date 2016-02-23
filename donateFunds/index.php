<?php
//资金页面
session_start();
$_SESSION[is_delete]=true;
if(empty($_SESSION[USER_ID])){
		$USER_ID=$_SESSION[LOGIN_USER_ID];
		//将GB2312转换成UTF-8字符串
		$USER_ID=iconv('GB2312','UTF-8',$USER_ID);
		$_SESSION[USER_ID]=$USER_ID;
	}
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
	header("location:loadFunds.php?loadFunds=1");
	exit();
}
header("location:loadFunds.php?loadFunds=1");
?>