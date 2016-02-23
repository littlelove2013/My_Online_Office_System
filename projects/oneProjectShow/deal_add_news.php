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
	$project=$_GET[project_id];
	//先查询时候已经存在
	$insert_data=array("project_project_id"=>$_GET[project_id],"news_news_id"=>$_GET[news_id]);
	$table="pro_have_news";
	$field="";
	$where="project_project_id=".$insert_data[project_project_id]." and news_news_id=".$insert_data[news_news_id];
	$result=getTableM($table,$field,$where);
	if(!empty($result)){
		echo "
			<script language='javascript'>
				alert('该新闻已存在，请勿重复添加!');
				history.go(-2);
			</script>
		";
	}
	//合法则做添加
	$result1=insertTableM("pro_have_news",$insert_data);
	if($result1){
		echo "
			<script language='javascript'>
				alert('添加成功!');
				window.location.href='project_news.php?project_id=".$project."';
			</script>
		";
	}else{
		echo "
			<script language='javascript'>
				alert('添加失败!');
				history.go(-2);
			</script>
		";
	}
?>
</body>
</html>