<?php
	include("../../Tools/getMysqlDataFun.php");
	if($_POST[update]=='修改'){
		//做修改
		$data=$_POST[my_project];
		//不必修改立项日期
		unset($data[project_date]);
		
		if($data[project_name]==''){
			echo "
			<script language='javascript'>
				alert('项目名称不能为空!');
				history.go(-2);
			</script>
		";
		}
		//查找相同名称的项目是否存在
		$have_result=getTableM("project","","project_name=".$data[project_name]);
		if(!empty($have_result)){
			echo "
			<script language='javascript'>
				alert('该项目名称已存在!');
				history.go(-2);
			</script>
		";
		}
		//修改为当前时间
		$data[project_lastedit_date]=time();
		$project_id=$_POST[project_id];
		
		$result=updateTable("project",$data,$project_id);
		if($result){
			//修改成功
			echo "
			<script language='javascript'>
				alert('修改成功!');
				window.location.href='../index.php';
			</script>
		";
		}else{
			//修改失败
			echo "
			<script language='javascript'>
				alert('修改失败!');
				history.go(-2);
			</script>
		";
		}
		
	}
	if($_POST[insert]=='添加'){
		//做插入
		$data=$_POST[my_project];
		if($data[project_name]==''){
			echo "
			<script language='javascript'>
				alert('项目名称不能为空!');
				history.go(-2);
			</script>
		";
		}
		$insertData[project_name]=$data[project_name];
		$insertData[project_date]=strtotime($data[project_date]);;
		$insertData[project_recorder_id]=$data[project_recorder_id];
		$insertData[project_lastedit_id]=$data[project_lastedit_id];
		$insertData[project_lastedit_date]=time();
		$insertData[project_manage_id]=$data[project_manage_id];
		$insertData[project_fundrise_id]=$data[project_fundrise_id];
		$insertData[project_type_id]=$data[project_type_id];
		$insertData[project_state_id]=$data[project_state_id];
		$insertData[project_level_id]=$data[project_level_id];
		$insertData[project_remarks]=$data[project_remarks];
		//print_r($insertData);
		//insertTable会对Tbale_name做检查
		$result = insertTable("project",$insertData);
		if($result){
			//插入成功
			echo "<script language='javascript'>alert('成功!');	window.location.href='../index.php';</script>";
		}else{
			//插入失败
			echo "<script language='javascript'>alert('插入失败!');	history.go(-3);	</script>";
		}
		
	}
	
	//print_r($_POST);

?>