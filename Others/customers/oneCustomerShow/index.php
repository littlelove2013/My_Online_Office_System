<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css">
<title></title>
<style type="text/css">
/* common styling */
/* set up the overall width of the menu div, the font and the margins */
.menu {
font-family: arial, sans-serif; 
width:100%; 
margin:0; 
margin:50px 0;
}
/* remove the bullets and set the margin and padding to zero for the unordered list */
.menu ul {
padding:0; 
margin:0;
list-style-type: none;
}
/* float the list so that the items are in a line and their position relative so that the drop down list will appear in the right place underneath each list item */
.menu ul li {
float:left; 
position:relative;
}
/* style the links to be 104px wide by 30px high with a top and right border 1px solid white. Set the background color and the font size. */
.menu ul li a, .menu ul li a:visited {
display:block; 
text-align:center; 
text-decoration:none; 
width:104px; 
height:30px; 
color:#000; 
border:1px solid #fff;
border-width:1px 1px 0 0;
background:#c9c9a7; 
line-height:30px; 
font-size:11px;
}
/* make the dropdown ul invisible */
.menu ul li ul {
display: none;
}
/* specific to non IE browsers */
/* set the background and foreground color of the main menu li on hover */
.menu ul li:hover a {
color:#fff; 
background:#b3ab79;
}
/* make the sub menu ul visible and position it beneath the main menu list item */
.menu ul li:hover ul {
display:block; 
position:absolute; 
top:31px; 
left:0; 
width:105px;
}
/* style the background and foreground color of the submenu links */
.menu ul li:hover ul li a {
display:block; 
background:#faeec7; 
color:#000;
}
/* style the background and forground colors of the links on hover */
.menu ul li:hover ul li a:hover {
background:#dfc184; 
color:#000;
}
</style>
</head>

<body>
<a href="../index.php">
<img width="50" height="30" src="../../../image/submit.png" />
</a>
<?php
	
	header("Content-Type:text/html;charset=utf8");
	if( empty($_GET[customer_type]) || empty($_GET[customer_id]) ){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../../notLogin.html';
			</script>
		";
	}
	include("../../../Tools/showPage.php");
	include("../../../Tools/getMysqlDataFun.php");
	include("../../../Tools/showTable.php");
	$data=array();
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
			$data=getTable($table,$field,$_GET[customer_id]);
			$data=current($data);
			if($data[生日]!=''){
				$data[生日]=date("Y-m-d",$data[生日]);
			}
			if($data[性别]==0){
				$data[性别]='男';
			}else
				if($data[性别]==1){
					$data[性别]='女';
				}else{
					$data[性别]='性别不详';
				}
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
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
		$data=getTable($table,$field,$_GET[customer_id]);
		$data=current($data);
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
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
		$data=getTable($table,$field,$_GET[customer_id]);
		$data=current($data);
		$customerData=new showTable($data);
		$customerData->Display($data[name].$_GET[customer_type].'信息');
		//print_r($data);
			break;
	}
?>
<?php 
	switch($_GET[customer_type]){
	case '个人':
?>
<div class="menu">
	<ul>
		<li>
			<a class="hide" href="#">更多信息</a>
            <ul>
            	<li>
                	<a href="more_info/getMyDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我的捐赠</a>
                </li>
                <li>
                	<a href="more_info/getMyManageGroupDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我管理的集体</a>
                </li>
                <li>
                	<a href="more_info/getMyGroupDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我所属的集体</a>
                </li>
                 <li>
                	<a href="more_info/getMyManageCompanyDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我管理的公司</a>
                </li>
                 <li>
                	<a href="more_info/getMyCompanyDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我所属的公司</a>
                </li>
                <li>
                	<a href="more_info/getMyIntercourseRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">我的交往记录</a>
                </li>
            </ul>
		</li>
	</ul>
</div>
<?php

	break;
	case '集体':
?>
<div class="menu">
	<ul>
		<li>
			<a class="hide" href="#">更多信息</a>
            <ul>
            	<li>
                	<a href="more_info/getGroupDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">集体捐赠记录</a>
                </li>
                <li>
                	<a href="more_info/getGroupManagerDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">集体负责人</a>
                </li>
                <li>
                	<a href="more_info/getGroupMembersDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">集体成员</a>
                </li>
                <li>
                	<a href="more_info/getGroupIntercourseRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">集体交往记录</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<?php
	break;
	case '机构':
?>
<div class="menu">
	<ul>
		<li>
			<a class="hide" href="#">更多信息</a>
            <ul>
            	<li>
                	<a href="more_info/getCompanyDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">机构捐赠记录</a>
                </li>
                <li>
                	<a href="more_info/getCompanyManagerDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">机构负责人</a>
                </li>
                <li>
                	<a href="more_info/getCompanyMembersDonatedRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">机构成员</a>
                </li>
                <li>
                	<a href="more_info/getCompanyIntercourseRecorder.php?customer_id=<?php echo $_GET[customer_id] ?>" target="more_info">集体交往记录</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<?php
	break;
}
?>
<div>
	<iframe width="100%" height="600px" src="../../noItemSelect.html" name="more_info">
    	您的浏览器不支持本页面
    </iframe>
</div>
<?php
	//include("../../../Tools/showTable.php");
	//$customerData=new showTable($data);
	//$customerData->Display($data[name].$_GET[customer_type].'信息');
?>
</body>
</html>