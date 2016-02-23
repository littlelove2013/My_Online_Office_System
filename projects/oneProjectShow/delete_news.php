<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
	if(empty($_GET[project_id])||empty($_GET[news_id])){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../Others/noItemSelect.html';
			</script>
		";
	}
	include("../../Tools/getMysqlDataFun.php");
	//对pro_have_news作删除
	$project=$_GET[project_id];
	$news_id=$_GET[news_id];
	$result=deleteTableM("pro_have_news","project_project_id=".$project." and news_news_id=".$news_id);
	if($result){
		echo "
			<script language='javascript'>
				alert('删除成功!');
				window.location.href='project_news.php?project_id=".$project."';
			</script>
		";
	}else{
		echo "
			<script language='javascript'>
				alert('删除失败!');
				history.go(-1);
			</script>
		";
	}
?>
</body>
</html>