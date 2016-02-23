<?php
	include("../../Tools/getMysqlDataFun.php");
	if($_POST[update]=='修改'){
		//做修改
		$data=$_POST[spend_funds];
		//支出日期可以修改
		$data[spend_funds_date]=strtotime($data[spend_funds_date]);
		if($data[spend_funds_amount]==''||$data[spend_funds_amount]==0){
			echo "
			<script language='javascript'>
				alert('支出金额不能为0!');
				history.go(-2);
			</script>
		";
		}
		//修改为当前时间
		$data[spend_funds_lastedit_date]=time();
		$spend_funds_id=$_POST[spend_funds_id];
		
		$result=updateTable("spend_funds",$data,$spend_funds_id);
		if($result){
			//修改成功
			echo "
			<script language='javascript'>
				alert('修改成功!');
				history.go(-3);
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
		print_r($_POST);
		$data=$_POST[spend_funds];
		if($data[spend_funds_amount]==''||$data[spend_funds_amount]==0){
			echo "
			<script language='javascript'>
				alert('支出金额不能为0!');
				history.go(-1);
			</script>
			";
		}
		print_r($data);
		$insertData[spend_funds_project_id]=$data[spend_funds_project_id];
		$insertData[spend_funds_amount]=$data[spend_funds_amount];
		$insertData[spend_funds_recorder_id]=$data[spend_funds_recorder_id];
		$insertData[spend_funds_lastedit_id]=$data[spend_funds_lastedit_id];
		$insertData[spend_funds_lastedit_date]=time();
		$insertData[spend_funds_date]=strtotime($data[spend_funds_date]);
		$insertData[spend_funds_purpose_id]=$data[spend_funds_purpose_id];
		$insertData[spend_funds_remarks]=$data[spend_funds_remarks];
		$insertData[spend_funds_aproved_dept_id]=$data[spend_funds_aproved_dept_id];
		$insertData[spend_funds_manage_id]=$data[spend_funds_manage_id];
		$insertData[spend_funds_approved_id]=$data[spend_funds_approved_id];
		$insertData[spend_funds_benefit_dept_id]=$data[spend_funds_benefit_dept_id];
		//print_r($insertData);
		$result = insertTableM("spend_funds",$insertData);
		if($result){
			//插入成功
			echo "<script language='javascript'>alert('成功!');	history.go(-3);	</script>";
		}else{
			//插入失败
			echo "
			<script language='javascript'>
				alert('插入失败!');
				history.go(-1);
			</script>
		";
		}
		
	}
	
	//print_r($_POST);

?>