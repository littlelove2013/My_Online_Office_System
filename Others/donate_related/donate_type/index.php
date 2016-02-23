<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>purpose</title>
</head>

<body>
<?php
	include("../../../Tools/getMysqlDataFun.php");
	include("../../../Tools/showPage.php");
	//$getData=getPurposeName();
	$field="donate_type_id as id,donate_type_name as name";
	$table='donate_type';
	$getData=getTable($table,$field);
	//echo "<p>";
	//print_r($getData);
?>
	<div>
    	<?php
			//添加一列操作栏
			foreach($getData as $keys=>$values){
				$values['操作']="<a href='insertUpdate.php?name=".urlencode($values[name])."&id=".$values[id]."'>编辑</a>
								&nbsp;&nbsp;
								<a href='deleteP.php?id=".$values[id]."'>删除</a>";
				$getData[$keys]=$values;
			}
			//print_r($getData);
			$page=new showPage($getData,'index.php');
			//$page->setPageNum(1);
			$insertMenu="<a href='insertUpdate.php'>添加类型</a>";
			$page->Display('捐赠类型('.$insertMenu.")");
		?>
    </div>
</body>
</html>