<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css" />
<title>添加相关新闻</title>
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
	//echo "GET:";
	$had_news_id_src=$_GET[had_news_id];
	//直接转义过来会有转义字符，去掉之后就可以正常了
	$had_news_id_src=str_replace("\\","",$had_news_id_src);
	//echo $had_news_id_src;
	//print_r($res);
	//echo json_last_error();
	$had_news_id=json_decode($had_news_id_src);
	//echo "<br/>had_news_id:<br/>";
	//print_r($had_news_id);
	$current_file = basename($_SERVER['SCRIPT_NAME']);
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showPage.php");
	//获取新闻列表
	$data=getTable("news","news_id as id,news_name as title,news_link as '链接',news_date as '日期',news_remark as '备注'");
	//echo "<br/>data:<br/>";
	//print_r($data);
	foreach($data as $keys=>$values){
		$values["日期"]=date("Y-m-d H:i:s",$values["日期"]);
		if(in_array($values[id],$had_news_id)){
			$values['操作']="<font color='#FF0000'>已添加</font>";
		}else{
			$values['操作']="<a id='table_td' href='deal_add_news.php?project_id=".$project_id."&news_id=".$values[id]."'>添加</a>";
		}
		$data[$keys]=$values;
	}
	$showPage=new showPage($data,$current_file);
	$showPage->Display("添加新闻");
?>
</body>
</html>