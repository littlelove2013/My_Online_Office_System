<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>
<form name="insertUpdateManage" method="post" action="">
<?php
//首先，是customer_type=集体或者公司，表示管理集体或者公司
//其次，如果存在manage则表示是管理，如果没有则表示加入该集体（公司）
//personal_id为必选项，表示参与的人员

//本文档用于对已定的人选择管理集体或者公司
//只需要两个字段，人的字段（已定）,集体或者公司的字段
if(empty($_GET[customer_type]))
{
	echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../../../notLogin.html';
			</script>
		";
}
//echo "customer_type=".$_GET[customer_type]."<br/>";
//echo "personal_id=".$_GET[personal_id]."<br>";

	include("../../../../../Tools/getMysqlDataFun.php");
	include("../../../../../Tools/showTable.php");
//设置隐藏字段
//获取customer字段的值
$customer_data=array();
$select="";


if(!empty($_GET[manage]) ){
	//表示添加管理
	switch($_GET[customer_type]){
	case '个人':
		//此处是以集体或者公司名义添加负责人
		$customer_data=getTable("personal",'personal_id as id,personal_name as name');
		if(!empty($_GET[company_id])){
			//添加company负责人
			echo "<input type='hidden' name='personal_manage_company[company_company_id]' value='".$_GET[company_id]."'/>";
			$select="<select id='selectCustomer' name='personal_manage_company[personal_personal_id]'>";
			foreach($customer_data as $keys=>$values){
				$select.="<option value='".$values[id]."'>".$values[name]."</option>";
			}
			$select.="</select>";
			
			$data=array("公司负责人"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('添加公司负责人');
			echo "<input type='submit' name='insert' value='添加公司负责人'>";
			
		}
		else
			if(!empty($_GET[group_id])){
				//添加集体负责人
				echo "<input type='hidden' name='personal_manage_group[group_group_id]' value='".$_GET[group_id]."'/>";
				$select="<select id='selectCustomer' name='personal_manage_group[personal_personal_id]'>";
				foreach($customer_data as $keys=>$values){
					$select.="<option value='".$values[id]."'>".$values[name]."</option>";
				}
				$select.="</select>";
				
				$data=array("集体负责人"=>$select);
				//表示是新添加
				$table=new showTable($data);
				$table->Display('添加集体负责人');
				echo "<input type='submit' name='insert' value='添加集体负责人'>";
			}else{
				echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
				";
			}
		break;
	case '集体':
		if(empty($_GET[personal_id]))
		{
			echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
			";
		}
		$customer_data=getTable("group",'group_id as id,group_name as name');
		
		echo "<input type='hidden' name='manage_group[personal_personal_id]' value='".$_GET[personal_id]."'/>";
		$select="<select id='selectCustomer' name='manage_group[group_group_id]'>";
		foreach($customer_data as $keys=>$values){
			$select.="<option value='".$values[id]."'>".$values[name]."</option>";
		}
		$select.="</select>";
		
		
		$data=array("集体"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('添加管理集体');
			echo "<input type='submit' name='insert' value='添加管理集体'>";
		
		
		break;
	case '机构':
		//此处说明是以个人名义添加管理机构
		if(empty($_GET[personal_id]))
		{
			echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
			";
		}
		$customer_data=getTable("company",'company_id as id,company_name as name');
		
		echo "<input type='hidden' name='manage_company[personal_personal_id]' value='".$_GET[personal_id]."'/>";
		$select="<select id='selectCustomer' name='manage_company[company_company_id]'>";
		foreach($customer_data as $keys=>$values){
			$select.="<option value='".$values[id]."'>".$values[name]."</option>";
		}
		$select.="</select>";
		
		$data=array("机构"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('添加管理机构');
			echo "<input type='submit' name='insert' value='添加管理机构'>";
		break;
	
	}
}
else{
	//表示加入
	switch($_GET[customer_type]){
	case '个人':
		//此处是以集体或者公司名义添加新成员
		$customer_data=getTable("personal",'personal_id as id,personal_name as name');
		if(!empty($_GET[company_id])){
			//添加company负责人
			echo "<input type='hidden' name='personal_company[company_company_id]' value='".$_GET[company_id]."'/>";
			$select="<select id='selectCustomer' name='personal_company[personal_personal_id]'>";
			foreach($customer_data as $keys=>$values){
				$select.="<option value='".$values[id]."'>".$values[name]."</option>";
			}
			$select.="</select>";
			
			$data=array("公司成员"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('添加公司公司成员');
			echo "<input type='submit' name='insert' value='添加公司成员'>";
			
		}
		else
			if(!empty($_GET[group_id])){
				//添加集体负责人
				echo "<input type='hidden' name='personal_group[group_group_id]' value='".$_GET[group_id]."'/>";
				$select="<select id='selectCustomer' name='personal_group[personal_personal_id]'>";
				foreach($customer_data as $keys=>$values){
					$select.="<option value='".$values[id]."'>".$values[name]."</option>";
				}
				$select.="</select>";
				
				$data=array("集体成员"=>$select);
				//表示是新添加
				$table=new showTable($data);
				$table->Display('添加集体成员');
				echo "<input type='submit' name='insert' value='添加集体成员'>";
			}else{
				echo "
				<script language='javascript'>
					alert('错误访问本页面group!');
					window.location.href='../../../../../notLogin.html';
				</script>
				";
			}
		break;
	case '集体':
		if(empty($_GET[personal_id]))
		{
			echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
			";
		}
		$customer_data=getTable("group",'group_id as id,group_name as name');
		
		echo "<input type='hidden' name='_group[personal_personal_id]' value='".$_GET[personal_id]."'/>";
		$select="<select id='selectCustomer' name='_group[group_group_id]'>";
		foreach($customer_data as $keys=>$values){
			$select.="<option value='".$values[id]."'>".$values[name]."</option>";
		}
		$select.="</select>";
		
		$data=array("集体"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('加入集体');
			echo "<input type='submit' name='insert' value='加入集体'>";
		
		break;
	case '机构':
		if(empty($_GET[personal_id]))
		{
			echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
			";
		}
		$customer_data=getTable("company",'company_id as id,company_name as name');
		
		echo "<input type='hidden' name='_company[personal_personal_id]' value='".$_GET[personal_id]."'/>";
		$select="<select id='selectCustomer' name='_company[company_company_id]'>";
		foreach($customer_data as $keys=>$values){
			$select.="<option value='".$values[id]."'>".$values[name]."</option>";
		}
		$select.="</select>";
		
		
		$data=array("机构"=>$select);
			//表示是新添加
			$table=new showTable($data);
			$table->Display('加入机构');
			echo "<input type='submit' name='insert' value='加入机构'>";	
		break;
	
	}
	
}
?>
</form>
<body>
</body>
<?php
	//处理获取的值
	//echo "添加Mode前<p>";
	//include("DB/Mode.php");
	//echo "添加Mode中<p>";
	$mode=new Mode('group_have');
	//echo "POST之前<p>";
	if(!empty($_POST[insert])){
		//echo "POST成功<p>";
		switch($_POST[insert]){
			case '添加管理集体':
				$data=$_POST[manage_group];
				//print_r($data);
				$mode->setOptionsField('');
				$mode->setOptionsTable("manage_group");
				$mode->setOptionsWhere("group_group_id=".$data[group_group_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('该集体已有人管理，请解除管理关系后再添加!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[personal_personal_id]=$data[personal_personal_id];
					$insertData[group_group_id]=$data[group_group_id]; 
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('插入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('插入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '添加管理机构':
				$data=$_POST[manage_company];
				$mode->setOptionsField('');
				$mode->setOptionsTable("manage_company");
				$mode->setOptionsWhere("company_company_id=".$data[company_company_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('该机构已有人管理，请解除管理关系后再添加!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					$insertData=array();
					$insertData[personal_personal_id]=$data[personal_personal_id];
					$insertData[company_company_id]=$data[company_company_id]; 
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('插入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('插入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '加入集体':
				$data=$_POST[_group];
				$mode->setOptionsField('');
				$mode->setOptionsTable("group_have");
				$mode->setOptionsWhere("group_group_id=".$data[group_group_id]." and personal_personal_id=".$data[personal_personal_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('你已经在该集体里了!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[group_group_id]=$data[group_group_id]; 
					$insertData[personal_personal_id]=$data[personal_personal_id];
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('加入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('加入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '加入机构':
				$data=$_POST[_company];
				$mode->setOptionsField('');
				$mode->setOptionsTable("company_have");
				$mode->setOptionsWhere("company_company_id=".$data[company_company_id]." and personal_personal_id=".$data[personal_personal_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('你已经在该机构里了!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[company_company_id]=$data[company_company_id]; 
					$insertData[personal_personal_id]=$data[personal_personal_id];
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('加入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('加入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '添加公司负责人':
				$data=$_POST[personal_manage_company];
				$mode->setOptionsField('');
				$mode->setOptionsTable("manage_company");
				$mode->setOptionsWhere("company_company_id=".$data[company_company_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('该机构已有人管理，请解除管理关系后再添加!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					$insertData=array();
					$insertData[personal_personal_id]=$data[personal_personal_id];
					$insertData[company_company_id]=$data[company_company_id]; 
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('插入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('插入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '添加集体负责人':
				$data=$_POST[personal_manage_group];
				$mode->setOptionsField('');
				$mode->setOptionsTable("manage_group");
				$mode->setOptionsWhere("group_group_id=".$data[group_group_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('该集体已有人管理，请解除管理关系后再添加!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[personal_personal_id]=$data[personal_personal_id];
					$insertData[group_group_id]=$data[group_group_id]; 
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('插入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('插入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '添加公司成员':
				$data=$_POST[personal_company];
				$mode->setOptionsField('');
				$mode->setOptionsTable("company_have");
				$mode->setOptionsWhere("company_company_id=".$data[company_company_id]." and personal_personal_id=".$data[personal_personal_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('你已经在该机构里了!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[company_company_id]=$data[company_company_id]; 
					$insertData[personal_personal_id]=$data[personal_personal_id];
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('加入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('加入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
			case '添加集体成员':
				$data=$_POST[personal_group];
				$mode->setOptionsField('');
				$mode->setOptionsTable("group_have");
				$mode->setOptionsWhere("group_group_id=".$data[group_group_id]." and personal_personal_id=".$data[personal_personal_id]);
				//检查该字段是否已经存在
				$result=$mode->select();
				if(!empty($result)){
					//说明该字段已经存在
					echo "
					<script language='javascript'>
						alert('你已经在该集体里了!');
						window.location.href='../../../../noItemSelect.html';
					</script>
					";
				}else{
					//该字段不存在直接做修改
					//相对$insertData=array();置空
					$insertData=array();
					$insertData[group_group_id]=$data[group_group_id]; 
					$insertData[personal_personal_id]=$data[personal_personal_id];
					//设置where为空
					$mode->setOptionsWhere("");
					$result1=$mode->insert($insertData);
					if($result1){
					//说明修改完成
						echo "
						<script language='javascript'>
							alert('加入成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}else{
						echo "
						<script language='javascript'>
							alert('加入失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
					}
				}
				break;
		}
	}
	
?>
</html>