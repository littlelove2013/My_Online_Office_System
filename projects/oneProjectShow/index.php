<?php
	header("Content-Type:text/html;charset=utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>oneProjectShow</title>
<link href="../../Tools/CSS/testTableCss.css" rel="stylesheet" type="text/css" />
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
<div>
	<a href="../index.php" target="_top">
    	<img src="../../image/submit.png" width="50" height="30" />
    </a>
</div>
<?php
	if(empty($_GET[project_id])){
		echo "
			<script language='javascript'>
				alert('错误访问本页面!');
				window.location.href='../../Others/noItemSelect.html';
			</script>
		";
	}
	date_default_timezone_set('Asia/Shanghai');//设置为本地时间
	$project_id=$_GET[project_id];
	include("../../Tools/getMysqlDataFun.php");
	include("../../Tools/showTable.php");
	//获取指定的项目信息
	$field="
	project_id as id,
		project_name as '项目名称',
		project_recorder_id as '记录人',
		project_lastedit_id as '最后编辑人',
		pro_manage_dept_name as '管理部门',
		fundrise_person_name as '筹款专员',
		project_type_name as '项目类型',
		project_state_name as '项目状态',
		project_level_name as '项目级别',
		totle_donated as '总捐赠',
		totle_spend as '总支出',
		totle_donated-totle_spend as '剩余',
		project_date as '立项日期',
		project_lastedit_date as '最后编辑日期'";
	$table="
		project inner join pro_manage_dept on project_manage_id=pro_manage_dept_id
			 inner join fundrise_person on project_fundrise_id=fundrise_person_id
			 inner join project_type on project_type.project_type_id=project.project_type_id
			 inner join project_state on project_state.project_state_id=project.project_state_id
			 inner join project_level on project_level.project_level_id=project.project_level_id
			 inner join (select project_id as all_donated_id,
								case when sum(donated_funds_amount) is null then 0 else sum(donated_funds_amount) end
								as totle_donated
						 from project left outer join donated_funds on project_id=donated_funds_project_id
						 -- where project.project_id=donated_funds_project_id
						 group by project_id) all_donated on all_donated_id=project.project_id
			 inner join (select project_id as all_spend_id,
								case when sum(spend_funds_amount) is null then 0 else sum(spend_funds_amount) end
								as totle_spend
						 from project left outer join spend_funds on project_id=spend_funds_project_id
						 group by project_id) all_spend on all_spend_id=project.project_id
";
	$data=getTableM($table,$field,"project_id=".$project_id);
	$data=current($data);
	//echo "data:<br/>";
	//print_r($data);
	//将日期改成字符串
	$data['立项日期']=date("Y-m-d",$data['立项日期']);
	$data['最后编辑日期']=date("Y-m-d H:i:s",$data['最后编辑日期']);
	$showData=new showTable($data);
	$update="(<a href=\"../insertUpdate/index.php?project_id=".$project_id."\">编辑</a>)";
	$showData->Display($data[项目名称].$update);
?>

<div class="menu">
	<ul>
		<li><a class="hide" href="#">更多信息</a>
        	<ul>
            	<li><a href="../../donateFunds/loadFunds.php?loadFunds=1&project_id=<?php echo $project_id;?>" target="showDonate">接受捐赠</a></li>
                <li><a href="../../spendFunds/loadFunds.php?loadFunds=1&project_id=<?php echo $project_id;?>" target="showDonate">支出记录</a></li>
                <li><a href="project_news.php?project_id=<?php echo $project_id;?>" target="showDonate">相关新闻</a></li>
            </ul>
		</li>
	</ul>
</div>
<div class="clear"> </div>
</div>
<div align="center">
	<iframe width="100%" height="600px" name="showDonate" src="../../Others/noItemSelect.html">
    </iframe>
</div>
</body>
</html>