<?php
	if(empty($_GET[customer_type]) ){
			//没有传递客户类型，则报错
			echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	include("../../../Tools/getMysqlDataFun.php");
	//新增事务
	if($_POST[insert]=='添加'){
		switch($_GET[customer_type]){
		case '个人':
		$data=$_POST[personal];
		if($date['personal_date']!=''){
			$date['personal_date']=strtotime($date['personal_date']);
		}
		//print_r($data);
		if(insertTable('personal',$data)){
			echo "
					<script language='javascript'>
						alert('添加成功');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('添加失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
		}
			break;
		case '集体':
		//获取集体的值
		$data=$_POST[group];
		//print_r($data);
		if(insertTable('group',$data)){
			echo "
					<script language='javascript'>
						alert('添加成功');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('添加失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
					
		}
			break;
		case '机构':
		//获取机构的值
		$data=$_POST[company];
		//print_r($data);
		if(insertTable('company',$data)){
			echo "
					<script language='javascript'>
						alert('添加成功');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('添加失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."');
					</script>
					";
					
		}
			break;
		}
	}
	//修改事务
	if($_POST[update]=='修改'){
		//修改事务
		switch($_GET[customer_type]){
		case '个人':
		$data=$_POST[personal];
		//print_r($data);
		if($data['personal_date']!=''){
			$data['personal_date']=strtotime($data['personal_date']);
		}
		//print_r($data);
		if(updateTable('personal',$data,$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('修改成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('修改失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."&customer_id=".$_GET[customer_id]."');
					</script>
					";
		}
			break;
		case '集体':
		//获取集体的值
		$data=$_POST[group];
		//print_r($data);
		if(updateTable('group',$data,$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('修改成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('修改失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."&customer_id=".$_GET[customer_id]."');
					</script>
					";
					
		}
			break;
		case '机构':
		//获取机构的值
		$data=$_POST[company];
		//print_r($data);
		if(updateTable('company',$data,$_GET[customer_id])){
			echo "
					<script language='javascript'>
						alert('修改成功');
						window.location.href('../index.php');
					</script>
					";
		}else{
			
			echo "
					<script language='javascript'>
						alert('修改失败\\nTips:带*为必填项');
						window.location.href('insertUpdate.php?customer_type=".$_GET[customer_type]."&customer_id=".$_GET[customer_id]."');
					</script>
					";
					
		}
			break;
		}
	}
?>