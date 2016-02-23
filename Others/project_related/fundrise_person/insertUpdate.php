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
<div align="left" style="margin-top:20px;">
<?php 
//附加函数库
include("../../../Tools/getMysqlDataFun.php");
//此处获取存在id和dept_id的数据库内容
$table = 'fundrise_person';
if(!empty($_GET[id])){
	$fundrise_person=current(getTable($table,'',$_GET[id]));
	if(empty($fundrise_person)){
		echo "
			<script language='javascript'>
				alert('不存在此条记录！');
				window.location.href('index.php');
			</script>
		";
	}
	//print_r($fundrise_person);
}
//获取部门列表
	$dept=getTable('pro_manage_dept');
	//print_r($dept);
	//echo "<p>".$approved[approved_name]."<p>";
?>
	<form name="insertUpdate" action="" method="post">
    	<p>请填写信息，带<font color="#FF0000">*</font>为必填项目</p>
    	<font color="#FF0000">*</font>筹款人：<input type="text" name="fundrise_person_name" value="<?php echo $fundrise_person[fundrise_person_name]; ?>" /><br/><br/>
        <input type="hidden" name="fundrise_person_id" value="<?php echo $fundrise_person[fundrise_person_id]; ?>" />
        <font color="#FF0000">*</font>所属部门：<select name="selectDept" id="selectDept">
        	<?php
            	foreach($dept as $key=>$value){
					echo "<option value='".$value[pro_manage_dept_id]."'>".$value[pro_manage_dept_name]."</option> ";
				}
			?>
        </select><br/><br/>
        <!-- 此处用于自动选择，不用于POST传递 -->
        <input type="hidden" id="fundrise_person_dept_id" value="<?php echo $fundrise_person[fundrise_person_dept_id]; ?>" />
        
        <font color="#FF0000">*</font>座机：<input type="text" name="fundrise_person_landline" value="<?php echo $fundrise_person[fundrise_person_landline]; ?>" /><br/><br/>
        手机：<input type="tel" name="fundrise_person_cellphone" value="<?php echo $fundrise_person[fundrise_person_cellphone]; ?>" /><br/><br/>
        邮件：<input type="email" name="fundrise_person_email" value="<?php echo $fundrise_person[fundrise_person_email]; ?>" /><br/><br/>
        传真：<input type="text" name="fundrise_person_fax" value="<?php echo $fundrise_person[fundrise_person_fax]; ?>" /><br/><br/>
        邮编：<input type="text" name="fundrise_person_zipcode" value="<?php echo $fundrise_person[fundrise_person_zipcode]; ?>" />
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
	if($_POST[insert]=='添加'){
		//做添加操作
		if($_POST[fundrise_person_name]!=''&&$_POST[fundrise_person_landline]!=''){
			$data=array($_POST[fundrise_person_name],$_POST['selectDept'],$_POST[fundrise_person_landline],$_POST[fundrise_person_cellphone],$_POST[fundrise_person_email],$_POST[fundrise_person_fax],$_POST[fundrise_person_zipcode]);
			//print_r($data);
			$result=insertTable('fundrise_person',$data);
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
		if(is_numeric($_GET[id])&&$_POST[fundrise_person_name]!=''&&$_POST[fundrise_person_landline]!=''){
			//$data=array('fundrise_person_name'=>$_POST[fundrise_person_name],);
			$data=array('fundrise_person_name'=>$_POST[fundrise_person_name],'fundrise_person_dept_id'=>$_POST['selectDept'],'fundrise_person_landline'=>$_POST[fundrise_person_landline],'fundrise_person_cellphone'=>$_POST[fundrise_person_cellphone],'fundrise_person_email'=>$_POST[fundrise_person_email],'fundrise_person_fax'=>$_POST[fundrise_person_fax],'fundrise_person_zipcode'=>$_POST[fundrise_person_zipcode]);
			$result=updateTable('fundrise_person',$data,$_GET[id]);
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
<script language="javascript">
	var sel=document.getElementById('fundrise_person_dept_id').value;
	if(sel == ''){
		document.getElementById('selectDept').value=1;
	}else{
		document.getElementById('selectDept').value=sel;
	}
</script>
</html>