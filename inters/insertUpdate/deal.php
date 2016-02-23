<?php
	session_start();
	//print_r($_POST);
	include("../../Tools/getMysqlDataFun.php");
	$insertJoinIntercourse=$_POST[insertJoinIntercourse];
	$insertIntercourse=$_POST[insertIntercourse];
	//echo "insertJoinIntercourse:<p>";
	//print_r($insertJoinIntercourse);
	//echo "insertIntercourse:<p>";
	//print_r($insertIntercourse);
	if($insertIntercourse[intercourse_theme]=="" || $insertIntercourse[intercourse_content]==""){
		echo "
				<script language='javascript'>
					alert('主题和内容不能为空!');
					history.go(-1);
				</script>
				";
	}
	if($_POST[update]=='修改'){
		//对捐赠数据
		$intercourse_id=$_POST[intercourse_id];
		//相对intercourse的表进行更改
		$insertIntercourse[intercourse_lastedit_date]=time();
		//对日期进行更改
		$insertIntercourse[intercourse_date]=strtotime($insertIntercourse[intercourse_date]);
		
		$result=updateTable("intercourse",$insertIntercourse,$intercourse_id);
		
		if($result){
			//对join_intercourse进行修改
			//1、先对原表进行删除
			$result1=deleteTableM("join_intercourse","intercourse_intercourse_id=".$intercourse_id);
			//2、再进行添加
			$personal_info=$insertJoinIntercourse[personal_personal_id];
			//print_r($personal_info);
			$group_info=$insertJoinIntercourse[group_group_id];
			$company_info=$insertJoinIntercourse[company_company_id];
			$len=max(array(count($personal_info),count($group_info),count($company_info)));
			//echo "len:".$len."<p>";
			$result2=true;
			for($i=0;$i<$len;$i++){
				$insertData[group_group_id]=$group_info[$i];
				$insertData[personal_personal_id]=$personal_info[$i];
				$insertData[company_company_id]=$company_info[$i];
				$insertData[intercourse_intercourse_id]=$intercourse_id; 	
				//echo "<br/>insertData:<br/>";
				//print_r($insertData);
				$result2=insertTableM("join_intercourse",$insertData);
				if(!$result2) break;
			}
			if($result2){
				echo "
				<script language='javascript'>
					alert('修改成功!');
					history.go(-3);
				</script>
				";
			}else{
				echo "
					<script language='javascript'>
						alert('修改2失败!');
						history.go(-1);
					</script>
				";
			}
		}else{
			echo "
			<script language='javascript'>
				alert('修改交往记录1失败!');
				history.go(-1);
			</script>
		";
		}
	}
	if($_POST[insert]=='添加'){
		//查询该主题时候已经存在，如果已经存在，则不可插入
		$searchData=getTableM("intercourse","","intercourse_theme='".$insertIntercourse[intercourse_theme]."'");
		//echo "seach:<p>";
		//print_r($searchData);
		if(!empty($searchData)){
		//说明该名称的主题已经存在，不能再插入
		echo "
				<script language='javascript'>
					alert('该主题已经存在!');
					history.go(-1);
				</script>
				";
		}
		//添加信息
		$insertData1[intercourse_theme]=$insertIntercourse[intercourse_theme];
		//echo "date:".$insertIntercourse[intercourse_date];
		$insertData1[intercourse_date]=strtotime($insertIntercourse[intercourse_date]);
		$insertData1[intercourse_recorder_id]=$insertIntercourse[intercourse_recorder_id];
		$insertData1[intercourse_lastedit_id]=$insertIntercourse[intercourse_lastedit_id];
		$insertData1[intercourse_lastedit_date]=time();
		$insertData1[intercourse_content]=$insertIntercourse[intercourse_content];
		echo "<br/>insertData1:<br/>";
		print_r($insertData1);
		$result=insertTableM("intercourse",$insertData1);
		if($result[0]){
			//如果插入成功
			//2、再进行添加
			$personal_info=$insertJoinIntercourse[personal_personal_id];
			//print_r($personal_info);
			$group_info=$insertJoinIntercourse[group_group_id];
			$company_info=$insertJoinIntercourse[company_company_id];
			$len=max(array(count($personal_info),count($group_info),count($company_info)));
			//echo "len:".$len."<p>";
			$result2=true;
			for($i=0;$i<$len;$i++){
				$insertData2[group_group_id]=$group_info[$i];
				$insertData2[personal_personal_id]=$personal_info[$i];
				$insertData2[company_company_id]=$company_info[$i];
				//result[1]含有刚才插入的最后一个id
				$insertData2[intercourse_intercourse_id]=$result[1]; 	
				//echo "<br/>insertData:<br/>";
				//print_r($insertData2);
				$result2=insertTableM("join_intercourse",$insertData2);
				if(!$result2) break;
			}
			if($result2){
				echo "
				<script language='javascript'>
					alert('添加成功!');
					history.go(-3);
				</script>
				";
			}else{
				echo "
					<script language='javascript'>
						alert('添加2失败!');
						history.go(-1);
					</script>
				";
			}
		}else{
			echo "
			<script language='javascript'>
				alert('添加1失败!');
				history.go(-1);
			</script>
		";
		}
	}
	
?>