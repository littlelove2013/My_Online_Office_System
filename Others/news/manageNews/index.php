<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>新闻管理</title>
</head>

<body>
<?php
	include("../../../Tools/getMysqlDataFun.php");
	include("../../../Tools/showPage.php");
	date_default_timezone_set('Asia/Shanghai');//设置为本地时间
	
	$field="news_id as id,news_name as title,news_link as '链接',news_date as '最后编辑',news_remark as '备注'";
	$table="news";
	$getData=getTable($table,$field);
?>
<div>
	<?php
		//添加一列操作栏
			foreach($getData as $keys=>$values){
				$values['操作']="<a href='insertUpdate.php?id=".$values[id]."'>编辑</a>
								&nbsp;&nbsp;
								<a href='deleteP.php?id=".$values[id]."'>删除</a>";
				//对日期进行字符串化
				$values['最后编辑']=date("Y-m-d H:i:s",$values['最后编辑']);
				$getData[$keys]=$values;
			}
			$getData=array_sort($getData,'最后编辑','desc');
			//print_r($getData);
			$page=new showPage($getData,'index.php');
			//$page->setPageNum(1);
			$insertMenu="<a href='insertUpdate.php'>添加</a>";
			$page->Display('新闻管理('.$insertMenu.")");
	?>
</div>
</body>
</html>