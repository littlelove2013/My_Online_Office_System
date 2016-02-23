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
	$field="approved_id as id,approved_name as name,pro_manage_dept_name as  '部门名称',approved_landline as '座机',approved_cellphone as '手机',approved_email as '邮箱',approved_fax as '传真',approved_zipcode as '邮编'";
	$table="approved inner join pro_manage_dept on approved_dept_id=pro_manage_dept_id";
	$getData=getTable($table,$field);
	//echo "<p>";
	//print_r($getData);
?>
	<div>
    	<?php
			//添加一列操作栏
			foreach($getData as $keys=>$values){
				$values['操作']="<a href='insertUpdate.php?id=".$values[id]."'>编辑</a>
								&nbsp;&nbsp;
								<a href='deleteP.php?id=".$values[id]."'>删除</a>";
				$getData[$keys]=$values;
			}
			$getData=array_sort($getData,'id','asc');
			//print_r($getData);
			$page=new showPage($getData,'http://localhost/test_TD_OA/Others/spend_related/approved/index.php');
			//$page->setPageNum(1);
			$insertMenu="<a href='insertUpdate.php'>添加</a>";
			$page->Display('批准人('.$insertMenu.")");
		?>
    </div>
</body>
</html>