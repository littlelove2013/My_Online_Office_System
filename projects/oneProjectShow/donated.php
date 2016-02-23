<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
	//由一个项目id：project_id查询捐赠记录
	if(empty($_GET[project_id])){
	echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../Others/noItemSelect.html';
			</script>
		";
	}
	//
	
?>
</body>
</html>