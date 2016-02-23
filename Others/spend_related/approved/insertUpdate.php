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
if(!empty($_GET[id])){
	$approved=current(getTable('approved','',$_GET[id]));
	if(empty($approved)){
		echo "
			<script language='javascript'>
				alert('不存在此条记录！');
				window.location.href('index.php');
			</script>
		";
	}
	//print_r($approved);
}
//获取部门列表
	$dept=getTable('pro_manage_dept');
	//print_r($dept);
	//echo "<p>".$approved[approved_name]."<p>";
?>
	<form name="insertUpdate" action="" method="post">
    	<p>请填写信息，带<font color="#FF0000">*</font>为必填项目</p>
    	<font color="#FF0000">*</font>批准人：<input type="text" name="approved_name" value="<?php echo $approved[approved_name]; ?>" /><br/><br/>
        <input type="hidden" name="approved_id" value="<?php echo $approved[approved_id]; ?>" />
        <font color="#FF0000">*</font>所属部门：<select name="selectDept" id="selectDept">
        	<?php
            	foreach($dept as $key=>$value){
					echo "<option value='".$value[pro_manage_dept_id]."'>".$value[pro_manage_dept_name]." ";
				}
			?>
        </select><br/><br/>
        <!-- 此处用于自动选择，不用于POST传递 -->
        <input type="hidden" id="approved_dept_id" value="<?php echo $approved[approved_dept_id]; ?>" />
        
        <font color="#FF0000">*</font>座机：<input type="tel" name="approved_landline" value="<?php echo $approved[approved_landline]; ?>" /><br/><br/>
        手机：<input type="tel" name="approved_cellphone" value="<?php echo $approved[approved_cellphone]; ?>" /><br/><br/>
        邮件：<input type="email" name="approved_email" value="<?php echo $approved[approved_email]; ?>" /><br/><br/>
        传真：<input type="text" name="approved_fax" value="<?php echo $approved[approved_fax]; ?>" /><br/><br/>
        邮编：<input type="text" name="approved_zipcode" value="<?php echo $approved[approved_zipcode]; ?>" />
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
		if($_POST[approved_name]!=''&&$_POST[approved_landline]!=''){
			$data=array($_POST[approved_name],$_POST['selectDept'],$_POST[approved_landline],$_POST[approved_cellphone],$_POST[approved_email],$_POST[approved_fax],$_POST[approved_zipcode]);
			print_r($data);
			$result=insertTable('approved',$data);
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
		if(is_numeric($_GET[id])&&$_POST[approved_name]!=''&&$_POST[approved_landline]!=''){
			$data=array('approved_name'=>$_POST[approved_name],'approved_dept_id'=>$_POST['selectDept'],'approved_landline'=>$_POST[approved_landline],'approved_cellphone'=>$_POST[approved_cellphone],'approved_email'=>$_POST[approved_email],'approved_fax'=>$_POST[approved_fax],'approved_zipcode'=>$_POST[approved_zipcode]);
			//$data=array('approved_name'=>$_POST[approved_name]);
			$result=updateTable('approved',$data,$_GET[id]);
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
	var sel=document.getElementById('approved_dept_id').value;
	if(sel == ''){
		document.getElementById('selectDept').value=1;
	}else{
		document.getElementById('selectDept').value=sel;
	}
</script>
</html>