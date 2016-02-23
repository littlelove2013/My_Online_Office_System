<?php
	header("Content-Type:text/html;charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>

<body>
<?php
	header("Content-Type:text/html;charset=utf8");
	include("../../../Tools/showPage.php");
	include("../../../Tools/getMysqlDataFun.php");
	include("../../../Tools/showTable.php");
	if(empty($_GET[customer_type]) ){
			//没有传递客户类型，则报错
			echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	if( empty($_GET[customer_id]) ){
		//说明是添加页面
		switch($_GET[customer_type]){
		case '个人':
		//获取个人的值
		$data=array(	
						"客户类型"=>"个人",
						"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='personal[personal_name]' placeholder='名字'/>",
						"<font color='#FF0000'>*</font>性别"=>"
								<input class='insertUpdate' type='radio' name='personal[personal_sex]' value='0' /> 男
								<input class='insertUpdate' type='radio' name='personal[personal_sex]' value='1' /> 女	",
						'生日'=>"<input class='insertUpdate' type='date' name='personal[personal_date]' placeholder='生日'/>",
						'民族'=>"<input class='insertUpdate' type='text' name='personal[personal_nation]' placeholder='民族'/>",
						'籍贯'=>"<input class='insertUpdate' type='text' name='personal[personal_origin]' placeholder='籍贯'/>",
						'国家'=>"<input class='insertUpdate' type='text' name='personal[personal_country]' placeholder='现居国家'/>",
						'省市'=>"<input class='insertUpdate' type='text' name='personal[personal_province]' placeholder='现居省市'/>",
						'城市'=>"<input class='insertUpdate' type='text' name='personal[personal_city]' placeholder='现居城市'/>",
						'详细地址'=>"<input class='insertUpdate' type='text' name='personal[personal_address]' placeholder='现居地址'/>",
						"<font color='#FF0000'>*</font>联系电话"=>"<input class='insertUpdate' type='text' name='personal[personal_phone_num]' placeholder='联系电话'/>",
						'个人邮箱'=>"<input class='insertUpdate' type='email' name='personal[personal_email]' placeholder='个人邮箱（格式）'/>",
						'传真'=>"<input class='insertUpdate' type='text' name='personal[personal_fax]' placeholder='传真'/>",
						'邮编'=>"<input class='insertUpdate' type='text' name='personal[personal_zipcode]' placeholder='邮编'/>",
						'备注'=>"<textarea class='insertUpdate' name='personal[personal_remarks]'></textarea>"
			);
			//print_r($data);
			break;
		case '集体':
		//获取集体的值
		$data=array(
			"客户类型"=>"集体",
			"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='group[group_name]' placeholder='名字'/>",
			'备注'=>"<textarea class='insertUpdate' name='group[group_remarks]'></textarea>"
		);
		//print_r($data);
			break;
		case '机构':
		//获取机构的值
		$data=array(
			"客户类型"=>"机构",
			"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='company[company_name]' placeholder='名字'/>",
			"<font color='#FF0000'>*</font>地址"=>"<input class='insertUpdate' type='text' name='company[company_address]' placeholder='地址'/>",
			"<font color='#FF0000'>*</font>邮编"=>"<input class='insertUpdate' type='text' name='company[company_zipcode]' placeholder='邮编'/>",
			"<font color='#FF0000'>*</font>联系电话"=>"<input class='insertUpdate' type='text' name='company[company_phone_num]' placeholder='联系电话' />",
			"<font color='#FF0000'>*</font>机构邮箱"=>"<input class='insertUpdate' type='email' name='company[company_email]' placeholder='邮箱（格式）'/>",
			"<font color='#FF0000'>*</font>传真"=>"<input class='insertUpdate' type='text' name='company[company_fax]' placeholder='传真'/>",
			'备注'=>"<textarea class='insertUpdate' name='company[company_remarks]'></textarea>"
		);
		//print_r($data);
			break;
		}
		echo "<form method='post' action='deal.php?customer_type=".$_GET[customer_type]."' name='insertData'>";
		$insertData=new showTable($data);
		$insertData->Display("添加".$_GET[customer_type]."信息");
		
		echo "<input type='submit' name='insert' value='添加' align='absmiddle'/></form>";
	}
	else{
		//是修改页面
		$customerData=array();
		//获取相应类别的数据
		switch($_GET[customer_type]){
		case '个人':
		//获取个人的值
			$table="personal";
			$field="
				'个人' as '客户类型',
		personal_name as 'name',
		personal_sex as '性别',
		personal_date as '生日',
		personal_nation as '民族',
		personal_origin as '籍贯',
		personal_country as '国家',
		personal_province as '省市',
		personal_city as '城市',
		personal_address as '详细地址',
		personal_phone_num as '联系电话',
		personal_email as '个人邮箱',
		personal_fax as '传真',
		personal_zipcode as '邮编',
		personal_remarks as '备注'
			";
			$customerData=getTable($table,$field,$_GET[customer_id]);
			$customerData=current($customerData);
			echo "生日：".$customerData[生日]."<p>";
			if($customerData[性别]==0){
				$male="checked='checked'";
			}else{
				$fmale="checked='checked'";
			}
			//设置个人的表值
			$data=array(	
						"客户类型"=>$customerData[客户类型],
						"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='personal[personal_name]' value='".$customerData[name]."' placeholder='名字'/>",
						"<font color='#FF0000'>*</font>性别"=>"
								<input class='insertUpdate' type='radio' name='personal[personal_sex]' ".$male." value='0' /> 男
								<input class='insertUpdate' type='radio' name='personal[personal_sex]' ".$fmale." value='1' /> 女	",
						'生日'=>"<input class='insertUpdate' type='date' name='personal[personal_date]' value='".date("Y-m-d",$customerData[生日])."' placeholder='生日'/>",
						'民族'=>"<input class='insertUpdate' type='text' name='personal[personal_nation]' value='".$customerData[民族]."' placeholder='民族'/>",
						'籍贯'=>"<input class='insertUpdate' type='text' name='personal[personal_origin]' value='".$customerData[籍贯]."' placeholder='籍贯'/>",
						'国家'=>"<input class='insertUpdate' type='text' name='personal[personal_country]' value='".$customerData[国家]."' placeholder='现居国家'/>",
						'省市'=>"<input class='insertUpdate' type='text' name='personal[personal_province]' value='".$customerData[省市]."' placeholder='现居省市'/>",
						'城市'=>"<input class='insertUpdate' type='text' name='personal[personal_city]' value='".$customerData[城市]."' placeholder='现居城市'/>",
						'详细地址'=>"<input class='insertUpdate' type='text' name='personal[personal_address]' value='".$customerData[详细地址]."' placeholder='现居地址'/>",
						"<font color='#FF0000'>*</font>联系电话"=>"<input class='insertUpdate' type='text' name='personal[personal_phone_num]' value='".$customerData[联系电话]."' placeholder='联系电话'/>",
						'个人邮箱'=>"<input class='insertUpdate' type='email' name='personal[personal_email]' value='".$customerData[个人邮箱]."' placeholder='个人邮箱（格式）'/>",
						'传真'=>"<input class='insertUpdate' type='text' name='personal[personal_fax]' value='".$customerData[传真]."' placeholder='传真'/>",
						'邮编'=>"<input class='insertUpdate' type='text' name='personal[personal_zipcode]' value='".$customerData[邮编]."' placeholder='邮编'/>",
						'备注'=>"<textarea class='insertUpdate' name='personal[personal_remarks]'>".$customerData[备注]."</textarea>"
			);
			//print_r($data);
			break;
		case '集体':
		//获取集体的值
		$table="group";
		$field="
			'集体' as '客户类型',
		group_name as 'name',
		group_remarks as '备注'
		";
		$customerData=getTable($table,$field,$_GET[customer_id]);
		$customerData=current($customerData);
		$data=array(
			"客户类型"=>$customerData[客户类型],
			"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='group[group_name]' value='".$customerData[name]."' placeholder='名字'/>",
			'备注'=>"<textarea class='insertUpdate' name='group[group_remarks]'>".$customerData[备注]."</textarea>"
		);
		//print_r($data);
			break;
		case '机构':
		//获取机构的值
		$table="company";
		$field="
			'机构' as '客户类型',
		company_name as 'name',
		company_address as '地址',
		company_zipcode as '邮编',
		company_phone_num as '联系电话',
		company_email as '机构邮箱',
		company_fax as '传真',
		company_remarks as '备注'
		";
		$customerData=getTable($table,$field,$_GET[customer_id]);
		$customerData=current($customerData);
		$data=array(
			"客户类型"=>$customerData[客户类型],
			"<font color='#FF0000'>*</font>name"=>"<input class='insertUpdate' type='text' name='company[company_name]' value='".$customerData[name]."' placeholder='名字'/>",
			"<font color='#FF0000'>*</font>地址"=>"<input class='insertUpdate' type='text' name='company[company_address]' value='".$customerData[地址]."' placeholder='地址'/>",
			"<font color='#FF0000'>*</font>邮编"=>"<input class='insertUpdate' type='text' name='company[company_zipcode]' value='".$customerData[邮编]."' placeholder='邮编'/>",
			"<font color='#FF0000'>*</font>联系电话"=>"<input class='insertUpdate' type='text' name='company[company_phone_num]' value='".$customerData[联系电话]."' placeholder='联系电话' />",
			"<font color='#FF0000'>*</font>机构邮箱"=>"<input class='insertUpdate' type='email' name='company[company_email]' value='".$customerData[机构邮箱]."' placeholder='邮箱（格式）'/>",
			"<font color='#FF0000'>*</font>传真"=>"<input class='insertUpdate' type='text' name='company[company_fax]' value='".$customerData[传真]."' placeholder='传真'/>",
			'备注'=>"<textarea class='insertUpdate' name='company[company_remarks]'>".$customerData[备注]."</textarea>"
		);
		//print_r($data);
			break;
		}
		//
		echo "<form method='post' action='deal.php?customer_type=".$_GET[customer_type]."&customer_id=".$_GET[customer_id]."' name='updateData'>";
		$insertData=new showTable($data);
		$insertData->Display("修改".$_GET[customer_type]."信息");
		
		echo "<input type='submit' name='update' value='修改' align='absmiddle'/></form>";
	}
?>
</body>
</html>