<?php
	session_start();
	include("../../../../../Tools/getMysqlDataFun.php");
	$insertDonate=$_POST[insertDonate];
	//print_r($insertDonate);
	echo "<p>";
	$insertDonatedFunds=$_POST[insertDonatedFunds];
	//print_r($insertDonatedFunds);
	if($_POST[update]=='修改'){
		//对捐赠数据
		$result=updateTable("donated_funds",$insertDonatedFunds,$_POST[donate_donated_funds_id]);
		if($result){
			//对donate进行修改
			$result1=updateTableM("donate",$insertDonate,'donate_donated_funds_id='.$_POST[donate_donated_funds_id]);
			//注：当0行受影响时，会返回0值，此时不是出错，只是未改变而已
			//echo "result1:".$result1."<p>";
			if($result1>=0){
				echo "
				<script language='javascript'>
					alert('修改成功!');
					history.go(-3);
				</script>
				";
			}else{
				echo "
					<script language='javascript'>
						alert('修改失败!');
						history.go(-1);
					</script>
				";
			}
		}else{
			echo "
			<script language='javascript'>
				alert('修改失败!');
				history.go(-1);
			</script>
		";
		}
	}
	if($_POST[insert]=='添加'){
		//添加信息
		
		//先对捐赠资金进行插入
		$data[donated_funds_project_id]=$insertDonatedFunds[donated_funds_project_id];
		$data[donated_funds_amount]=$insertDonatedFunds[donated_funds_amount];
		$data[donated_funds_date]=$insertDonatedFunds[donated_funds_date];
		$data[donated_funds_donatetype_id]=$insertDonatedFunds[donated_funds_donatetype_id];
		$data[donated_funds_recorder_id]=$insertDonatedFunds[donated_funds_recorder_id];
		$data[donated_funds_lastedit_id]=$insertDonatedFunds[donated_funds_lastedit_id];
		$data[donated_funds_currency]=$insertDonatedFunds[donated_funds_currency];
		$data[donated_funds_remarks]=$insertDonatedFunds[donated_funds_remarks];
		echo "<p>";
		//print_r($data);
		$result=insertTableM("donated_funds",$data);
		if($result[0]){
			//如果插入成功
			$data1[donate_group_id]=$insertDonate[donate_group_id];
			$data1[donate_personal_id]=$insertDonate[donate_personal_id];
			$data1[donate_company_id]=$insertDonate[donate_company_id];
			$data1[donate_donated_funds_id]=$result[1];
			$data1[donate_customer_type]=$insertDonate[donate_customer_type];
			echo "<p>";
			//print_r($data1);
			$result1=insertTableM("donate",$data1);
			if($result1[0]){
				echo "
				<script language='javascript'>
					alert('添加成功!');
					history.go(-3);
				</script>
				";
			}else{
				echo "
			<script language='javascript'>
				alert('添加失败!');
				history.go(-1);
			</script>
				";
			}
		}else{
			echo "
			<script language='javascript'>
				alert('添加失败!');
				history.go(-1);
			</script>
		";
		}
	}
	
?>