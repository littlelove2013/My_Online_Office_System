<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>插入编辑</title>
</head>

<body>
<div align="center" style="margin-top:20px;">
	<form name="insertUpdate" action="" method="post">
    	<input type="text" name="project_level_name" value="<?php echo "$_GET[name]"; ?>" />
        <input type="hidden" name="project_level_id" value="<?php echo "$_GET[id]"; ?>" />
        <br/>
        <br/>
        <input type="submit"  <?php 
																if(empty($_GET[id])){
																	echo "
																	name='insert' value='添加'
																	"; 
																}else{
																	echo "
																	name='update' value='修改'
																	"; 
																}
								?>/>
    </form>
</div>
<?php
	include("../../../Tools/getMysqlDataFun.php");
	if($_POST[insert]=='添加'){
		//做添加操作
		if(!empty($_POST[project_level_name])&&$_POST[project_level_name]!=''){
			$data=array($_POST[project_level_name]);
			$table="project_level";
			$result=insertTable($table,$data);
			if($result){
				//插入成功
					echo "
					<script language='javascript'>
						alert('添加成功');
						window.location.href('index.php');
					</script>
					";
			}else{
				//插入失败
				echo "
					<script language='javascript'>
						alert('添加失败');
						window.location.href('index.php');
					</script>
					";
			}
		}else{
			echo "
					<script language='javascript'>
						alert('添加失败\n请输入正确的文档');
						window.location.href('insertUpdate.php');
					</script>
					";
		}
	}
	if($_POST[update]=='修改'){
		//做修改操作
		if(is_numeric($_GET[id])){
			$data=array('project_level_name'=>$_POST[project_level_name]);
			$table="project_level";
			$result=updateTable($table,$data,$_GET[id]);
			if($result){
				//修改成功
					echo "
					<script language='javascript'>
						alert('修改成功');
						window.location.href('index.php');
					</script>
					";
			}else{
				//插入失败
				echo "
					<script language='javascript'>
						alert('修改失败');
						window.location.href('index.php');
					</script>
					";
			}
		}else{
			echo "
					<script language='javascript'>
						alert('别乱搞！');
						window.location.href('insertUpdate.php');
					</script>
					";
		}
	}
?>
</body>
</html>