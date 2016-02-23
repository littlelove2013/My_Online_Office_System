<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>project_news</title>
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	if(empty($_GET[project_id])){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../Others/noItemSelect.html';
			</script>
		";
	}
	$project_id=$_GET[project_id];
	//echo $project_id."<p>";
	$current_file = basename($_SERVER['SCRIPT_NAME']);
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showPage.php");
	//获取本项目相关的新闻列表
	$table="pro_have_news inner join news on news_news_id=news_id
					  inner join project on project_project_id=project_id";
	$field="
		project_name as '项目名称',
		news_id,
		news_name as 'title',
		news_link as '链接',
		news_date as '日期',
		news_remark as '备注'
	";
	$where="project_id=".$project_id;
	$data=getTableM($table,$field,$where);
	$hadNews=array();
	foreach($data as $keys=>$values){
		$values["日期"]=date("Y-m-d H:i:s",$values["日期"]);
		$values['操作']="<a href=\"delete_news.php?project_id=".$project_id."&news_id=".$values[news_id]."\">删除项目相关</a>";
		$hadNews[]=$values[news_id];
		//unset($values[news_id]);
		$data[$keys]=$values;
	}
	//echo "::".urlencode(json_encode($hadNews))."<p>";
	$showPage=new showPage($data,$current_file);
	$insert="(<a href=\"add_pro_news.php?project_id=".$project_id."&had_news_id=".urlencode(json_encode($hadNews))."\">添加相关新闻</a>)";
	$showPage->Display("相关新闻".$insert);
?>
</body>
</html>