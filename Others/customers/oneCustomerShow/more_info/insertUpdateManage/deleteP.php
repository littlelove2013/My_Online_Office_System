<?php
	if(empty($_GET[customer_type])||empty($_GET[personal_id])||empty($_GET[id]))
{
	echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../../../notLogin.html';
			</script>
		";
}
include("../../../../../Tools/getMysqlDataFun.php");
if(!empty($_GET[manage]) ){
	switch($_GET[customer_type]){
	case '个人':
		//表示以集体或者机构的名义删除个人
		if(!empty($_GET[group])){
			//删除manage_group
			$result=deleteTableM("manage_group","group_group_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
			if($result){
				echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
			}else{
				echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
			}
		}else{
			if(!empty($_GET[company])){
				//删除manage_company
				$result=deleteTableM("manage_company","company_company_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
				if($result){
					echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
				}else{
					echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
				}
			}else{
					echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
				";
			}
		}
		break;
	case '集体':
		//删除管理
		//删除id和personal_id指定的行
		$result=deleteTableM("manage_group","group_group_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
		if($result){
			echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}else{
			echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}
		break;
	case '机构':
		//删除管理
		$result=deleteTableM("manage_company","company_company_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
		if($result){
			echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}else{
			echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}
		break;
	
	}
}
else{
	//表示所属机构
	switch($_GET[customer_type]){
	case '个人':
		//表示以集体或者机构的名义删除个人
		if(!empty($_GET[group])){
			//删除group_have
			$result=deleteTableM("group_have","group_group_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
			if($result){
				echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
			}else{
				echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
			}
		}else{
			if(!empty($_GET[company])){
				//删除company_have
				$result=deleteTableM("company_have","company_company_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
				if($result){
					echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
				}else{
					echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
				}
			}else{
					echo "
				<script language='javascript'>
					alert('错误访问本页面!');
					window.location.href='../../../../../notLogin.html';
				</script>
				";
			}
		}
		break;
	case '集体':
		//删除id和personal_id指定的行
		$result=deleteTableM("group_have","group_group_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
		if($result){
			echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}else{
			echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}
		//退出
		break;
	case '机构':
		//退出
		$result=deleteTableM("company_have","company_company_id=".$_GET[id]." and personal_personal_id=".$_GET[personal_id]);
		if($result){
			echo "
						<script language='javascript'>
							alert('成功!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}else{
			echo "
						<script language='javascript'>
							alert('失败!');
							window.location.href='../../../../noItemSelect.html';
						</script>
						";
		}
		break;
	}
	
}
?>